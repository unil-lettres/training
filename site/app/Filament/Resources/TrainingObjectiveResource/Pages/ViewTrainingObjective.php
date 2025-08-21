<?php

namespace App\Filament\Resources\TrainingObjectiveResource\Pages;

use App\Filament\Resources\TrainingObjectiveResource;
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
