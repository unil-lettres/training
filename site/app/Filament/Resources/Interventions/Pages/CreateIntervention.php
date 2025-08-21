<?php

namespace App\Filament\Resources\Interventions\Pages;

use App\Filament\Resources\Interventions\Interventions\Interventions\InterventionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIntervention extends CreateRecord
{
    protected static string $resource = InterventionResource::class;
}
