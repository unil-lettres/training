<?php

namespace App\Filament\Exports;

use App\Models\TrainingObjective;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TrainingObjectiveExporter extends Exporter
{
    protected static ?string $model = TrainingObjective::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Identifiant'),
            ExportColumn::make('name')
                ->label('Nom'),
            ExportColumn::make('created_at')
                ->label('Date de création'),
            ExportColumn::make('updated_at')
                ->label('Date de modification'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'L\'exportation de vos objectifs (formation) est terminée ('.number_format($export->successful_rows).').';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' enregistrement(s) non exporté(s).';
        }

        return $body;
    }
}
