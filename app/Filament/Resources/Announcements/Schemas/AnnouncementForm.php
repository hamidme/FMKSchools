<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->components([
                        Toggle::make('is_active')
                            ->label('Show on homepage')
                            ->helperText('Only one announcement shows at a time — the most recently updated active one.')
                            ->default(true),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->rows(4),
                        FileUpload::make('image')
                            ->image()
                            ->directory('announcements'),
                        TextInput::make('link_text')
                            ->label('Button text')
                            ->helperText('Leave blank to hide the button.')
                            ->maxLength(255),
                        TextInput::make('link_url')
                            ->label('Button link')
                            ->placeholder('https://... or /admissions/apply'),
                    ]),
            ]);
    }
}
