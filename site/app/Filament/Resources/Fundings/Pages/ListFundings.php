<?php

namespace App\Filament\Resources\Fundings\Pages;

use App\Filament\Resources\Fundings\Fundings\Fundings\FundingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundings extends ListRecords
{
    protected static string $resource = FundingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
