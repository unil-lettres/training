<?php

namespace App\Filament\Resources\Fundings\Pages;

use App\Filament\Resources\Fundings\Fundings\Fundings\FundingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFunding extends EditRecord
{
    protected static string $resource = FundingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
