<?php

namespace App\Filament\Resources\Tools\Pages;

use App\Filament\Resources\Tools\ToolResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTool extends ViewRecord
{
    protected static string $resource = ToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
