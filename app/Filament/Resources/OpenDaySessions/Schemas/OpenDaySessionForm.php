<?php

namespace App\Filament\Resources\OpenDaySessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OpenDaySessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->components([
                        Toggle::make('is_active')
                            ->label('Show on Open Day page')
                            ->default(true),
                        DatePicker::make('date')
                            ->required(),
                        TextInput::make('time_range')
                            ->label('Time')
                            ->placeholder('9:00 AM — 12:00 PM')
                            ->required(),
                        TextInput::make('description')
                            ->placeholder('General Open Day — all arms of the school')
                            ->required(),
                    ]),
            ]);
    }
}
