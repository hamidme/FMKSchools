<?php

/*
|--------------------------------------------------------------------------
| Replaceable site images
|--------------------------------------------------------------------------
|
| Every fixed image on the public site, grouped by the admin section it
| appears under on the "Site Images" page. Views reference a slot with
| @siteImage('key'); if the school has uploaded a replacement it's used,
| otherwise the bundled `default` file under public/ is.
|
| Slot keys must be unique across all groups and must not contain dots
| (they double as Livewire form field names). An image shown in several
| places (e.g. the principal's photo) is a single slot so it only has to
| be replaced once.
|
*/

return [

    'Logo & icons' => [
        'logo' => [
            'label' => 'School logo',
            'default' => '/images/fmks_logo.webp',
            'hint' => 'Header and footer. Square, transparent background works best.',
        ],
        'favicon' => [
            'label' => 'Browser tab icon',
            'default' => '/favicon.ico',
            'hint' => 'Square PNG, at least 180×180. Also used when the site is saved to a phone home screen.',
        ],
    ],

    'Homepage' => [
        'home_about_main' => [
            'label' => 'About section — large photo',
            'default' => '/images/about-main.webp',
            'hint' => 'Portrait (3:4).',
        ],
        'home_about_award' => [
            'label' => 'About section — top small photo',
            'default' => '/images/about-award.webp',
            'hint' => 'Square.',
        ],
        'home_about_grad' => [
            'label' => 'About section — bottom small photo',
            'default' => '/images/about-grad.webp',
            'hint' => 'Square.',
        ],
        'home_why_fmks' => [
            'label' => '"Why choose FMKS" background',
            'default' => '/images/why-fmks.webp',
            'hint' => 'Wide landscape, at least 1920px across. Shown behind a dark overlay.',
        ],
        'home_admissions_cta' => [
            'label' => 'Admissions banner photo',
            'default' => '/images/admissions-cta.webp',
            'hint' => 'Near the bottom of the homepage.',
        ],
    ],

    'People' => [
        'principal' => [
            'label' => 'Principal',
            'default' => '/images/principal.webp',
            'hint' => 'Portrait (3:4). Used on the homepage welcome message and the Leadership page.',
        ],
        'vp_academics' => [
            'label' => 'Vice Principal (Academics)',
            'default' => '/images/about/vp-academics.webp',
            'hint' => 'Leadership page. Landscape (4:3), face near the top.',
        ],
        'vp_admin' => [
            'label' => 'Vice Principal (Administration)',
            'default' => '/images/about/vp-admin.webp',
            'hint' => 'Leadership page. Landscape (4:3), face near the top.',
        ],
        'head_early_years' => [
            'label' => 'Head of Early Years',
            'default' => '/images/about/head-early-years.webp',
            'hint' => 'Leadership page. Landscape (4:3), face near the top.',
        ],
    ],

    'Programmes' => [
        'programme_early_years' => [
            'label' => 'Early Years',
            'default' => '/images/programmes/early-years.webp',
            'hint' => 'Homepage programme card and the Early Years page.',
        ],
        'programme_primary' => [
            'label' => 'Primary',
            'default' => '/images/programmes/primary.webp',
            'hint' => 'Homepage programme card and the Primary page.',
        ],
        'programme_junior_secondary' => [
            'label' => 'Junior Secondary',
            'default' => '/images/programmes/junior-secondary.webp',
            'hint' => 'Homepage programme card and the Secondary page.',
        ],
        'programme_senior_secondary' => [
            'label' => 'Senior Secondary',
            'default' => '/images/programmes/senior-secondary.webp',
            'hint' => 'Homepage programme card and the Secondary page.',
        ],
        'curriculum' => [
            'label' => 'Curriculum page',
            'default' => '/images/about/curriculum.webp',
            'hint' => 'Landscape.',
        ],
    ],

    'About pages' => [
        'our_story' => [
            'label' => 'Our Story page',
            'default' => '/images/about/our-story.webp',
            'hint' => 'Landscape (4:3).',
        ],
    ],

    'Facilities' => [
        'facility_classrooms' => [
            'label' => 'Classrooms',
            'default' => '/images/facilities/classrooms.webp',
            'hint' => 'Landscape (16:9).',
        ],
        'facility_science_lab' => [
            'label' => 'Science laboratory',
            'default' => '/images/facilities/science-lab.webp',
            'hint' => 'Landscape (16:9).',
        ],
        'facility_library' => [
            'label' => 'Library',
            'default' => '/images/facilities/library.webp',
            'hint' => 'Landscape (16:9).',
        ],
        'facility_ict_centre' => [
            'label' => 'ICT centre',
            'default' => '/images/facilities/ict-centre.webp',
            'hint' => 'Landscape (16:9).',
        ],
        'facility_sports' => [
            'label' => 'Sports facilities',
            'default' => '/images/facilities/sports.webp',
            'hint' => 'Landscape. Also used on the Student Life → Sports page.',
        ],
        'facility_assembly_hall' => [
            'label' => 'Assembly hall',
            'default' => '/images/facilities/assembly-hall.webp',
            'hint' => 'Landscape (16:9).',
        ],
    ],

];
