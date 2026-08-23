<?php

namespace App\Filament\Resources\OpenDaySessions\Pages;

use App\Filament\Resources\OpenDaySessions\OpenDaySessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOpenDaySessions extends ListRecords
{
    protected static string $resource = OpenDaySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
