<?php

namespace App\Filament\Resources\AnalysisObjectives\Pages;

use App\Filament\Resources\AnalysisObjectives\AnalysisObjectiveResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAnalysisObjective extends EditRecord
{
    protected static string $resource = AnalysisObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
