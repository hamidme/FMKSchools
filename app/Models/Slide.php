<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    protected $fillable = [
        'image',
        'tag',
        'headline',
        'subtext',
        'cta1_text',
        'cta1_url',
        'cta2_text',
        'cta2_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function toSliderArray(): array
    {
        return [
            'image' => Storage::url($this->image),
            'tag' => $this->tag,
            'headline' => $this->headline,
            'sub' => $this->subtext,
            'cta1' => [
                'text' => $this->cta1_text,
                'href' => $this->cta1_url,
            ],
            'cta2' => [
                'text' => $this->cta2_text,
                'href' => $this->cta2_url,
            ],
        ];
    }
}
