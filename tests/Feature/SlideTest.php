<?php

namespace Tests\Feature;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlideTest extends TestCase
{
    use RefreshDatabase;

    private function makeSlide(array $overrides = []): Slide
    {
        return Slide::create(array_merge([
            'image' => 'slides/test.webp',
            'tag' => 'Tag',
            'headline' => 'Headline',
            'subtext' => 'Subtext',
            'cta1_text' => 'Go',
            'cta1_url' => '/go',
            'cta2_text' => 'Also Go',
            'cta2_url' => '/also-go',
            'sort_order' => 0,
        ], $overrides));
    }

    public function test_homepage_only_shows_active_slides(): void
    {
        $this->makeSlide(['tag' => 'Active Slide', 'is_active' => true]);
        $this->makeSlide(['tag' => 'Inactive Slide', 'is_active' => false]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Active Slide');
        $response->assertDontSee('Inactive Slide');
    }

    public function test_slides_are_ordered_by_sort_order(): void
    {
        $this->makeSlide(['tag' => 'Second', 'sort_order' => 2]);
        $this->makeSlide(['tag' => 'First', 'sort_order' => 1]);

        $slides = Slide::where('is_active', true)->orderBy('sort_order')->pluck('tag')->all();

        $this->assertSame(['First', 'Second'], $slides);
    }

    public function test_admin_can_view_slide_list(): void
    {
        $user = User::factory()->create();
        $this->makeSlide(['tag' => 'Admin Visible Slide']);

        $this->actingAs($user)
            ->get('/admin/slides')
            ->assertOk()
            ->assertSee('Admin Visible Slide');
    }
}
