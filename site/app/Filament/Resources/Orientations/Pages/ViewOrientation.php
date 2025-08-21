<?php

namespace App\Filament\Resources\Orientations\Pages;

use App\Filament\Resources\Orientations\OrientationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrientation extends ViewRecord
{
    protected static string $resource = OrientationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
