<?php

use App\Http\Controllers\ContactController;
use App\Models\Announcement;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'latestNews' => NewsPost::published()->orderByDesc('published_at')->limit(3)->get(),
        'announcement' => Announcement::current(),
    ]);
})->name('home');

Route::redirect('/about', '/about/our-story');
Route::view('/about/our-story', 'about.our-story')->name('about.our-story');
Route::view('/about/leadership', 'about.leadership')->name('about.leadership');
Route::view('/about/faculty-staff', 'about.faculty-staff')->name('about.faculty-staff');
Route::view('/about/facilities', 'about.facilities')->name('about.facilities');

Route::redirect('/academics', '/academics/early-years');
Route::view('/academics/early-years', 'academics.early-years')->name('academics.early-years');
Route::view('/academics/primary', 'academics.primary')->name('academics.primary');
Route::view('/academics/secondary', 'academics.secondary')->name('academics.secondary');
Route::view('/academics/curriculum', 'academics.curriculum')->name('academics.curriculum');

Route::redirect('/admissions', '/admissions/apply');
Route::view('/admissions/apply', 'admissions.apply')->name('admissions.apply');
Route::view('/admissions/fees', 'admissions.fees')->name('admissions.fees');
Route::view('/admissions/open-day', 'admissions.open-day')->name('admissions.open-day');

Route::redirect('/student-life', '/student-life/clubs');
Route::view('/student-life/clubs', 'student-life.clubs')->name('student-life.clubs');
Route::view('/student-life/sports', 'student-life.sports')->name('student-life.sports');
Route::view('/student-life/achievements', 'student-life.achievements')->name('student-life.achievements');

Route::get('/news', function () {
    return view('news.index', [
        'posts' => NewsPost::published()->orderByDesc('published_at')->get(),
    ]);
})->name('news.index');

Route::get('/news/{news_post:slug}', function (NewsPost $news_post) {
    return view('news.show', [
        'post' => $news_post,
        'related' => NewsPost::published()
            ->where('id', '!=', $news_post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get(),
    ]);
})->name('news.show');

Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

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
    $newsPosts = NewsPost::published()->get();
    foreach ($newsPosts as $post) {
        $pages[] = [
            'url'        => route('news.show', $post, absolute: false),
            'priority'   => '0.6',
            'changefreq' => 'monthly',
            'lastmod'    => $post->published_at->toDateString(),
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
