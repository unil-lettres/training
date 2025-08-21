<?php

namespace App\Filament\Resources\AnalysisObjectives\Pages;

use App\Filament\Resources\AnalysisObjectives\AnalysisObjectiveResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAnalysisObjective extends ViewRecord
{
    protected static string $resource = AnalysisObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
