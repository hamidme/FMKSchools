<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_returns_null_when_no_active_announcement_exists(): void
    {
        Announcement::create(['title' => 'Old', 'message' => 'x', 'is_active' => false]);

        $this->assertNull(Announcement::current());
    }

    public function test_current_returns_the_most_recently_updated_active_announcement(): void
    {
        $older = Announcement::create(['title' => 'Older', 'message' => 'x', 'is_active' => true]);
        $older->forceFill(['updated_at' => now()->subDay()])->save();

        $newer = Announcement::create(['title' => 'Newer', 'message' => 'x', 'is_active' => true]);

        $this->assertSame($newer->id, Announcement::current()->id);
    }

    public function test_homepage_shows_active_announcement(): void
    {
        Announcement::create(['title' => 'Come to Open Day', 'message' => 'Details here', 'is_active' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Come to Open Day');
    }

    public function test_homepage_does_not_show_inactive_announcement(): void
    {
        Announcement::create(['title' => 'Hidden Announcement', 'message' => 'x', 'is_active' => false]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Hidden Announcement');
    }

    public function test_admin_can_view_announcement_list(): void
    {
        $user = User::factory()->create();
        Announcement::create(['title' => 'Admin Visible', 'message' => 'x', 'is_active' => true]);

        $this->actingAs($user)
            ->get('/admin/announcements')
            ->assertOk()
            ->assertSee('Admin Visible');
    }
}
