<?php

namespace App\Filament\Resources\FundingResource\Pages;

use App\Filament\Resources\FundingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFunding extends ViewRecord
{
    protected static string $resource = FundingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
