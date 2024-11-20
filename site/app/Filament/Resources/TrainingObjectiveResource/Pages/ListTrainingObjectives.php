<?php

namespace App\Filament\Resources\TrainingObjectiveResource\Pages;

use App\Filament\Resources\TrainingObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingObjectives extends ListRecords
{
    protected static string $resource = TrainingObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
