<?php

namespace App\Filament\Resources\RequestResource\Widgets;

use App\Filament\Resources\RequestResource;
use App\Models\Request;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRequests extends BaseWidget
{
    protected static ?string $heading = 'Dernières demandes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Request::query()
                    ->latest('created_at'),
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Libellé')
                    ->limit(50)
                    ->url(fn (Request $record) => RequestResource::getUrl('view', [$record])),
            ])->defaultPaginationPageOption(5);
    }
}
