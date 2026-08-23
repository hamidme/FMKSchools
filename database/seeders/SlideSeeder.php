<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slide::create([
            'image' => 'slides/slide-1.webp',
            'tag' => 'Welcome to FMKS',
            'headline' => 'Excellence in<br/>Education',
            'subtext' => 'Nurturing brilliant minds through academic excellence, strong values, and holistic development — from Crèche through to Senior Secondary.',
            'cta1_text' => 'Apply for 2026/2027',
            'cta1_url' => '/admissions/apply',
            'cta2_text' => 'Discover Our School',
            'cta2_url' => '#about',
            'sort_order' => 1,
        ]);

        Slide::create([
            'image' => 'slides/slide-2.webp',
            'tag' => 'Academic Excellence',
            'headline' => 'Shaping Leaders,<br/>Lighting Futures',
            'subtext' => 'Award-winning results, dedicated teachers, and a curriculum designed to prepare your child for a lifetime of impact.',
            'cta1_text' => 'Our Programmes',
            'cta1_url' => '/academics',
            'cta2_text' => 'View Achievements',
            'cta2_url' => '/student-life/achievements',
            'sort_order' => 2,
        ]);

        Slide::create([
            'image' => 'slides/slide-3.webp',
            'tag' => 'Admissions Open',
            'headline' => 'Your Child\'s Journey<br/>Begins Here',
            'subtext' => 'Applications are open for the 2026/2027 academic session. Join the FMKS family and give your child the future they deserve.',
            'cta1_text' => 'Apply Now',
            'cta1_url' => '/admissions/apply',
            'cta2_text' => 'Admissions Info',
            'cta2_url' => '/admissions',
            'sort_order' => 3,
        ]);
    }
}
