<?php

namespace App\Providers;

use App\Models\SiteImage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // @siteImage('principal') → URL of the school's upload for that slot,
        // or its bundled default. Slots are defined in config/site-images.php.
        Blade::directive('siteImage', fn (string $key) => "<?php echo e(\\".SiteImage::class."::url({$key})); ?>");
    }
}
