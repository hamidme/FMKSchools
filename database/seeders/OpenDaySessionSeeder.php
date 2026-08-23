<?php

namespace Database\Seeders;

use App\Models\OpenDaySession;
use Illuminate\Database\Seeder;

class OpenDaySessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OpenDaySession::create([
            'date' => '2026-09-19',
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'General Open Day — all arms of the school',
        ]);

        OpenDaySession::create([
            'date' => '2026-10-24',
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'Secondary School focused — JSS & SSS admissions',
        ]);

        OpenDaySession::create([
            'date' => '2026-11-21',
            'time_range' => '9:00 AM — 12:00 PM',
            'description' => 'Early Years & Primary focused',
        ]);
    }
}
