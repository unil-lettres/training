<?php

namespace App\Filament\Resources\TrainingObjectiveResource\Pages;

use App\Filament\Resources\TrainingObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingObjective extends EditRecord
{
    protected static string $resource = TrainingObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
