<?php

namespace Tests\Feature;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_news_post_list(): void
    {
        $user = User::factory()->create();
        $post = NewsPost::create([
            'title' => 'Test Post',
            'type' => 'news',
            'excerpt' => 'An excerpt.',
            'content' => 'Body content.',
            'published_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/admin/news-posts')
            ->assertOk()
            ->assertSee('Test Post');
    }

    public function test_admin_can_view_news_post_edit_page(): void
    {
        $user = User::factory()->create();
        $post = NewsPost::create([
            'title' => 'Editable Post',
            'type' => 'event',
            'excerpt' => 'An excerpt.',
            'content' => 'Body content.',
            'event_date' => '2026-09-01',
            'event_location' => 'Main Hall',
            'published_at' => now(),
        ]);

        $this->actingAs($user)
            ->get("/admin/news-posts/{$post->slug}/edit")
            ->assertOk()
            ->assertSee('Editable Post');
    }
}
