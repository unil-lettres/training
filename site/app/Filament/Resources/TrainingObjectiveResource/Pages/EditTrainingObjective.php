<?php

namespace App\Filament\Resources\TrainingObjectiveResource\Pages;

use App\Filament\Resources\TrainingObjectiveResource;
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
