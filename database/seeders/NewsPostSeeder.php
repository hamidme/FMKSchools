<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use Illuminate\Database\Seeder;

class NewsPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsPost::create([
            'title' => 'Open Day — Saturday 14 June 2026',
            'slug' => 'open-day-june-2026',
            'type' => 'event',
            'excerpt' => 'We are opening our doors to prospective families. Come and see our facilities, meet our teachers, and learn what makes FMKS the school of choice in the region.',
            'content' => <<<'MD'
Our June Open Day is the perfect opportunity for families considering FMKS for the 2026/2027 academic year to visit the school, tour our facilities, and speak directly with our teaching and administrative staff.

**What to expect:**
- Welcome address by the Principal
- Guided campus tours (classrooms, science labs, library, sports facilities)
- Meet-the-teacher sessions
- Q&A with current parents and students
- Admissions desk for enquiries and form collection

**Date:** Saturday, 14 June 2026
**Time:** 9:00am – 12:00pm
**Venue:** FMKS Campus, Surulere, Lagos

No registration required — just show up. We look forward to welcoming you.
MD,
            'event_date' => '2026-06-14',
            'event_location' => 'FMKS Campus, Surulere',
            'published_at' => '2026-05-10',
        ]);

        NewsPost::create([
            'title' => 'FMKS Records 98% WAEC Pass Rate for the Third Year Running',
            'slug' => 'waec-results-2026',
            'type' => 'news',
            'excerpt' => 'Our SSS3 students have once again achieved outstanding results in the West African Senior School Certificate Examination, with 98% obtaining five credits and above.',
            'content' => <<<'MD'
We are incredibly proud to announce that FMKS students in the 2025/2026 SSS3 class have recorded a 98% pass rate in the West African Senior School Certificate Examination (WASCE), with credits in five subjects and above including Mathematics and English Language.

This is the third consecutive year the school has maintained this standard — a testament to the dedication of our students and the commitment of our teaching staff.

Several students achieved distinctions across all nine subjects, and three students have already received early admission offers from the University of Lagos and Obafemi Awolowo University.

The Principal, in a statement to staff and parents, said: *"This result is not a surprise to us — it is the product of deliberate, consistent hard work from our students and their families. We are immensely proud."*

Congratulations to the Class of 2026.
MD,
            'published_at' => '2026-05-28',
        ]);

        NewsPost::create([
            'title' => 'Prize Giving Day 2026 — A Celebration of Excellence',
            'slug' => 'prize-giving-day-2026',
            'type' => 'event',
            'excerpt' => "Join us for our annual Prize Giving Day as we celebrate the achievements of our outstanding students across all arms of the school.",
            'content' => <<<'MD'
We are delighted to invite parents, guardians, and well-wishers to our Annual Prize Giving Day. This year's ceremony promises to be a memorable one as we honour students who have excelled academically, in sports, and in co-curricular activities.

The event will feature performances from our Music Club, a speech by the Principal, and the presentation of awards across all categories.

**Date:** Saturday, 12 July 2026
**Time:** 10:00am – 1:00pm
**Venue:** FMKS Main Hall

Light refreshments will be served. Seats are limited — please confirm your attendance by 5 July.
MD,
            'event_date' => '2026-07-12',
            'event_location' => 'FMKS Main Hall',
            'published_at' => '2026-06-15',
        ]);
    }
}
