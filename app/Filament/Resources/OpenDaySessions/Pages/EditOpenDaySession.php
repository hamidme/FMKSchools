<?php

namespace App\Filament\Resources\OpenDaySessions\Pages;

use App\Filament\Resources\OpenDaySessions\OpenDaySessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOpenDaySession extends EditRecord
{
    protected static string $resource = OpenDaySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
