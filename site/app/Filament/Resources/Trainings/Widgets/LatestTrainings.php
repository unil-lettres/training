<?php

namespace App\Filament\Resources\Trainings\Widgets;

use App\Filament\Resources\Trainings\Trainings\Trainings\TrainingResource;
use App\Models\Training;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTrainings extends BaseWidget
{
    protected static ?string $heading = 'Dernières formations';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Training::query()
                    ->latest('created_at'),
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->limit(50)
                    ->url(fn (Training $record) => TrainingResource::getUrl('view', [$record])),
            ])->defaultPaginationPageOption(5);
    }
}
