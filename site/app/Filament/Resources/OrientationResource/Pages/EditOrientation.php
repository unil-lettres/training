<?php

namespace App\Filament\Resources\OrientationResource\Pages;

use App\Filament\Resources\OrientationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrientation extends EditRecord
{
    protected static string $resource = OrientationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
