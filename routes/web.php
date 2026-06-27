<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Statamic\Facades\Entry;

Route::get('/sitemap.xml', function () {
    $pages = [
        ['url' => '/',                          'priority' => '1.0', 'changefreq' => 'weekly'],
        ['url' => '/about/our-story',           'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/about/leadership',          'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/about/faculty-staff',       'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/about/facilities',          'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/academics/early-years',     'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/academics/primary',         'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/academics/secondary',       'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/academics/curriculum',      'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/admissions/apply',          'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => '/admissions/fees',           'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/admissions/open-day',       'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => '/student-life/clubs',        'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/student-life/sports',       'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/student-life/achievements', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/news',                      'priority' => '0.8', 'changefreq' => 'daily'],
        ['url' => '/contact',                   'priority' => '0.6', 'changefreq' => 'yearly'],
    ];

    // Add news entries dynamically
    $newsEntries = Entry::query()->where('collection', 'news')->get();
    foreach ($newsEntries as $entry) {
        $pages[] = [
            'url'        => $entry->url(),
            'priority'   => '0.6',
            'changefreq' => 'monthly',
            'lastmod'    => $entry->date()->toDateString(),
        ];
    }

    $base = config('app.url');
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($pages as $page) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$base}{$page['url']}</loc>\n";
        if (isset($page['lastmod'])) {
            $xml .= "    <lastmod>{$page['lastmod']}</lastmod>\n";
        }
        $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
        $xml .= "    <priority>{$page['priority']}</priority>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
});
