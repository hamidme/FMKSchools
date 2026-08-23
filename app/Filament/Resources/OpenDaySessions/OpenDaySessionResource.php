<?php

namespace App\Filament\Resources\OpenDaySessions;

use App\Filament\Resources\OpenDaySessions\Pages\CreateOpenDaySession;
use App\Filament\Resources\OpenDaySessions\Pages\EditOpenDaySession;
use App\Filament\Resources\OpenDaySessions\Pages\ListOpenDaySessions;
use App\Filament\Resources\OpenDaySessions\Schemas\OpenDaySessionForm;
use App\Filament\Resources\OpenDaySessions\Tables\OpenDaySessionsTable;
use App\Models\OpenDaySession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OpenDaySessionResource extends Resource
{
    protected static ?string $model = OpenDaySession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Open Day Dates';

    protected static ?string $modelLabel = 'Open Day date';

    public static function form(Schema $schema): Schema
    {
        return OpenDaySessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpenDaySessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOpenDaySessions::route('/'),
            'create' => CreateOpenDaySession::route('/create'),
            'edit' => EditOpenDaySession::route('/{record}/edit'),
        ];
    }
}
