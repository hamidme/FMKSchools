<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * An uploaded replacement for one of the fixed image slots defined in
 * config/site-images.php. A slot with no row shows its bundled default.
 */
class SiteImage extends Model
{
    protected $fillable = [
        'key',
        'path',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => app()->forgetInstance('site-images.overrides'));
        static::deleted(fn () => app()->forgetInstance('site-images.overrides'));
    }

    /**
     * Every slot from the config, flattened to key => definition.
     *
     * @return array<string, array{label: string, default: string, hint?: string}>
     */
    public static function slots(): array
    {
        return Arr::collapse(config('site-images'));
    }

    public static function url(string $key): string
    {
        // Loaded once per request (pages use ~10 slots), cleared on any write.
        if (! app()->bound('site-images.overrides')) {
            app()->instance('site-images.overrides', static::pluck('path', 'key')->all());
        }

        $path = app('site-images.overrides')[$key] ?? null;

        if ($path !== null) {
            return Storage::disk('public')->url($path);
        }

        return static::slots()[$key]['default']
            ?? throw new \InvalidArgumentException("Unknown site image slot [{$key}].");
    }
}
