<?php

namespace Tests\Feature;

use App\Models\NewsPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsPostVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_excludes_future_dated_posts(): void
    {
        NewsPost::create(['title' => 'Past', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->subDay()]);
        NewsPost::create(['title' => 'Today', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()]);
        NewsPost::create(['title' => 'Future', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->addDays(5)]);

        $titles = NewsPost::published()->pluck('title')->all();

        $this->assertContains('Past', $titles);
        $this->assertContains('Today', $titles);
        $this->assertNotContains('Future', $titles);
    }

    public function test_homepage_does_not_show_future_dated_posts(): void
    {
        NewsPost::create(['title' => 'Visible Post', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->subDay()]);
        NewsPost::create(['title' => 'Scheduled Post', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->addWeek()]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Visible Post')
            ->assertDontSee('Scheduled Post');
    }

    public function test_news_index_does_not_show_future_dated_posts(): void
    {
        NewsPost::create(['title' => 'Visible Post', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->subDay()]);
        NewsPost::create(['title' => 'Scheduled Post', 'type' => 'news', 'excerpt' => 'x', 'content' => 'x', 'published_at' => now()->addWeek()]);

        $this->get('/news')
            ->assertOk()
            ->assertSee('Visible Post')
            ->assertDontSee('Scheduled Post');
    }
}
