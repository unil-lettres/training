<?php

namespace App\Filament\Resources\TrainingObjectives\Pages;

use App\Filament\Resources\TrainingObjectives\TrainingObjectiveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingObjectives extends ListRecords
{
    protected static string $resource = TrainingObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
