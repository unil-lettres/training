<?php

namespace App\Filament\Resources\Fundings\Pages;

use App\Filament\Resources\Fundings\Fundings\Fundings\FundingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFunding extends ViewRecord
{
    protected static string $resource = FundingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
