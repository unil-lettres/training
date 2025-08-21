<?php

namespace App\Filament\Resources\Interventions\Pages;

use App\Filament\Resources\Interventions\Interventions\Interventions\InterventionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIntervention extends ViewRecord
{
    protected static string $resource = InterventionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
