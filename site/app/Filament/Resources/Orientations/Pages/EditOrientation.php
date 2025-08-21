<?php

namespace App\Filament\Resources\Orientations\Pages;

use App\Filament\Resources\Orientations\Orientations\Orientations\OrientationResource;
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
