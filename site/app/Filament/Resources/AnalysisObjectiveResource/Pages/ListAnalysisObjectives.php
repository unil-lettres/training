<?php

namespace App\Filament\Resources\AnalysisObjectiveResource\Pages;

use App\Filament\Resources\AnalysisObjectiveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnalysisObjectives extends ListRecords
{
    protected static string $resource = AnalysisObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
