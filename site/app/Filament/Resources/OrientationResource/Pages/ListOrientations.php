<?php

namespace App\Filament\Resources\OrientationResource\Pages;

use App\Filament\Resources\OrientationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrientations extends ListRecords
{
    protected static string $resource = OrientationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
