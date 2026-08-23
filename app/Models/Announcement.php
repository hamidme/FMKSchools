<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'image',
        'link_url',
        'link_text',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        return static::where('is_active', true)->latest('updated_at')->first();
    }
}
