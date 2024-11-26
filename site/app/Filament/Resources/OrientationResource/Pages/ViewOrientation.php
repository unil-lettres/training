<?php

namespace App\Filament\Resources\OrientationResource\Pages;

use App\Filament\Resources\OrientationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrientation extends ViewRecord
{
    protected static string $resource = OrientationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
