<?php

namespace App\Filament\Resources\TrainingObjectives\Pages;

use App\Filament\Resources\TrainingObjectives\TrainingObjectives\TrainingObjectives\TrainingObjectiveResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingObjective extends ViewRecord
{
    protected static string $resource = TrainingObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
