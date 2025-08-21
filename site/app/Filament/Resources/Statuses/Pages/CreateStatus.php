<?php

namespace App\Filament\Resources\Statuses\Pages;

use App\Filament\Resources\Statuses\Statuses\Statuses\StatusResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStatus extends CreateRecord
{
    protected static string $resource = StatusResource::class;
}
