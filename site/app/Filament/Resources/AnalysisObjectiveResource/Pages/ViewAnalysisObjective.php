<?php

namespace App\Filament\Resources\AnalysisObjectiveResource\Pages;

use App\Filament\Resources\AnalysisObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAnalysisObjective extends ViewRecord
{
    protected static string $resource = AnalysisObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
