<?php

namespace Tests\Feature;

use App\Models\OpenDaySession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpenDaySessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_open_day_page_does_not_show_past_dates(): void
    {
        OpenDaySession::create([
            'date' => now()->subMonth(),
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'A past session',
        ]);
        OpenDaySession::create([
            'date' => now()->addMonth(),
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'An upcoming session',
        ]);

        $this->get('/admissions/open-day')
            ->assertOk()
            ->assertSee('An upcoming session')
            ->assertDontSee('A past session');
    }

    public function test_open_day_page_does_not_show_inactive_sessions(): void
    {
        OpenDaySession::create([
            'date' => now()->addMonth(),
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'A hidden session',
            'is_active' => false,
        ]);

        $this->get('/admissions/open-day')
            ->assertOk()
            ->assertDontSee('A hidden session');
    }

    public function test_open_day_page_shows_empty_state_when_no_sessions(): void
    {
        $this->get('/admissions/open-day')
            ->assertOk()
            ->assertSee('No Open Days are currently scheduled');
    }

    public function test_sessions_are_ordered_soonest_first(): void
    {
        OpenDaySession::create(['date' => now()->addMonths(2), 'time_range' => 'x', 'description' => 'Later']);
        OpenDaySession::create(['date' => now()->addMonth(), 'time_range' => 'x', 'description' => 'Sooner']);

        $descriptions = OpenDaySession::upcoming()->pluck('description')->all();

        $this->assertSame(['Sooner', 'Later'], $descriptions);
    }

    public function test_admin_can_view_open_day_session_list(): void
    {
        $user = User::factory()->create();
        OpenDaySession::create(['date' => now()->addMonth(), 'time_range' => 'x', 'description' => 'Admin Visible Session']);

        $this->actingAs($user)
            ->get('/admin/open-day-sessions')
            ->assertOk()
            ->assertSee('Admin Visible Session');
    }
}
