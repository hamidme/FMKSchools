<?php

namespace App\Filament\Resources\NewsPosts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->columnSpanFull(),
                        Select::make('type')
                            ->options([
                                'news' => 'News',
                                'event' => 'Event',
                            ])
                            ->default('news')
                            ->required(),
                        DatePicker::make('published_at')
                            ->label('Published')
                            ->default(now())
                            ->required(),
                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->helperText('Short summary shown on the listing page.')
                            ->rows(2)
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('news')
                            ->columnSpanFull(),
                        MarkdownEditor::make('content')
                            ->label('Content')
                            ->columnSpanFull(),
                    ]),
                Section::make('Event Details')
                    ->description('Only fill in for Event type posts.')
                    ->columns(2)
                    ->components([
                        DatePicker::make('event_date')
                            ->label('Event Date'),
                        TextInput::make('event_location')
                            ->label('Event Location')
                            ->placeholder('e.g. School Hall, Main Field'),
                    ]),
                Section::make('SEO')
                    ->collapsed()
                    ->components([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->helperText('Overrides the page title in search results. Keep under 60 characters.')
                            ->maxLength(60),
                        Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->helperText('Shown in search results. Keep between 120–160 characters. Falls back to Excerpt if left blank.')
                            ->rows(2),
                    ]),
            ]);
    }
}
