<?php

namespace App\Filament\Resources\Fundings\Pages;

use App\Filament\Resources\Fundings\Fundings\Fundings\FundingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFunding extends CreateRecord
{
    protected static string $resource = FundingResource::class;
}
