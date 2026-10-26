<?php

namespace Tests\Feature;

use App\Filament\Pages\SiteImages;
use App\Models\SiteImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SiteImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_show_bundled_defaults_when_nothing_uploaded(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/images/principal.webp')
            ->assertSee('/images/fmks_logo.webp');
    }

    public function test_uploaded_replacement_is_used_everywhere_the_slot_appears(): void
    {
        SiteImage::create(['key' => 'principal', 'path' => 'site-images/new-principal.webp']);

        $url = Storage::disk('public')->url('site-images/new-principal.webp');

        $this->get('/')->assertOk()->assertSee($url)->assertDontSee('/images/principal.webp');
        $this->get('/about/leadership')->assertOk()->assertSee($url)->assertDontSee('/images/principal.webp');
    }

    public function test_every_site_image_reference_in_views_is_a_defined_slot(): void
    {
        $slots = SiteImage::slots();

        foreach (array_merge(glob(resource_path('views/*.blade.php')), glob(resource_path('views/*/*.blade.php'))) as $file) {
            preg_match_all("/@siteImage\('([^']+)'\)/", file_get_contents($file), $matches);

            foreach ($matches[1] as $key) {
                $this->assertArrayHasKey($key, $slots, basename($file)." references unknown site image slot [{$key}].");
            }
        }
    }

    public function test_admin_can_view_site_images_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/site-images')
            ->assertOk()
            ->assertSee('Principal')
            ->assertSee('Facilities');
    }

    public function test_admin_can_upload_replace_and_remove_an_image(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        Livewire::test(SiteImages::class)
            ->set('data.principal', [UploadedFile::fake()->image('first.jpg')])
            ->call('save')
            ->assertHasNoErrors();

        $first = SiteImage::where('key', 'principal')->value('path');
        Storage::disk('public')->assertExists($first);

        // The uploader clears the current file before taking a new one.
        Livewire::test(SiteImages::class)
            ->set('data.principal', null)
            ->set('data.principal', [UploadedFile::fake()->image('second.jpg')])
            ->call('save');

        $second = SiteImage::where('key', 'principal')->value('path');
        $this->assertNotSame($first, $second);
        Storage::disk('public')->assertMissing($first);

        Livewire::test(SiteImages::class)
            ->set('data.principal', null)
            ->call('save');

        $this->assertDatabaseMissing('site_images', ['key' => 'principal']);
        Storage::disk('public')->assertMissing($second);
        $this->assertSame('/images/principal.webp', SiteImage::url('principal'));
    }
}
