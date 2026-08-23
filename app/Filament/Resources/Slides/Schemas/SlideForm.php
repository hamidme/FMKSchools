<?php

namespace App\Filament\Resources\Slides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->components([
                        Toggle::make('is_active')
                            ->label('Show in slider')
                            ->default(true),
                        FileUpload::make('image')
                            ->image()
                            ->directory('slides')
                            ->required(),
                        TextInput::make('tag')
                            ->label('Tag')
                            ->helperText('Small label above the headline, e.g. "Admissions Open".')
                            ->required(),
                        TextInput::make('headline')
                            ->helperText('Use <br/> for a line break, matching the existing slides.')
                            ->required(),
                        Textarea::make('subtext')
                            ->label('Supporting text')
                            ->rows(2)
                            ->required(),
                    ]),
                Section::make('Buttons')
                    ->columns(2)
                    ->components([
                        TextInput::make('cta1_text')
                            ->label('Primary button text')
                            ->required(),
                        TextInput::make('cta1_url')
                            ->label('Primary button link')
                            ->placeholder('/admissions/apply')
                            ->required(),
                        TextInput::make('cta2_text')
                            ->label('Secondary button text')
                            ->required(),
                        TextInput::make('cta2_url')
                            ->label('Secondary button link')
                            ->placeholder('/academics')
                            ->required(),
                    ]),
            ]);
    }
}
