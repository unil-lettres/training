<?php

namespace App\Filament\Resources\AnalysisObjectiveResource\Pages;

use App\Filament\Resources\AnalysisObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnalysisObjective extends EditRecord
{
    protected static string $resource = AnalysisObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
