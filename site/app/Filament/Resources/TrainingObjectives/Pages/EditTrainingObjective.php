<?php

namespace App\Filament\Resources\TrainingObjectives\Pages;

use App\Filament\Resources\TrainingObjectives\TrainingObjectives\TrainingObjectives\TrainingObjectiveResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingObjective extends EditRecord
{
    protected static string $resource = TrainingObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
