<?php

namespace App\Filament\Exports;

use App\Enums\RequestStatusAdmin;
use App\Enums\RequestType;
use App\Models\Request;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RequestExporter extends Exporter
{
    protected static ?string $model = Request::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Identifiant'),
            ExportColumn::make('name')
                ->label('Libellé'),
            ExportColumn::make('description')
                ->label('Description'),
            ExportColumn::make('filling_date')
                ->label('Date dépot'),
            ExportColumn::make('applicants')
                ->label('Demandeur(s)'),
            ExportColumn::make('theme')
                ->label('Thème'),
            ExportColumn::make('deadline')
                ->label('Délai production'),
            ExportColumn::make('level')
                ->label('Niveau requis'),
            ExportColumn::make('comments')
                ->label('Remarques'),
            ExportColumn::make('contact')
                ->label('Mail contact'),

            ExportColumn::make('extras.doctoral_school')
                ->label('École doctorale'),
            ExportColumn::make('extras.fns')
                ->label('Fns')
                ->formatStateUsing(function (?bool $state): string {
                    return $state ? 'Oui' : 'Non';
                }),
            ExportColumn::make('extras.doctoral_status')
                ->label('Doctorat statut'),
            ExportColumn::make('extras.doctoral_level')
                ->label('Niveau actuel'),
            ExportColumn::make('extras.tested_products')
                ->label('Produits testés'),
            ExportColumn::make('extras.teachers_nbr')
                ->label('Seul ou avec d\'autres enseignants')
                ->formatStateUsing(function (?bool $state): string {
                    return $state ? 'Oui' : 'Non';
                }),
            ExportColumn::make('extras.students_nbr')
                ->label('Avec un ou des étudiants')
                ->formatStateUsing(function (?bool $state): string {
                    return $state ? 'Oui' : 'Non';
                }),
            ExportColumn::make('extras.action_type')
                ->label('Intervention pour toute une classe, pendant les cours')
                ->formatStateUsing(function (?bool $state): string {
                    return $state ? 'Oui' : 'Non';
                }),

            ExportColumn::make('status_admin')
                ->label('Statut')
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    strtolower(RequestStatusAdmin::NEW->name) => RequestStatusAdmin::NEW->value,
                    strtolower(RequestStatusAdmin::PENDING->name) => RequestStatusAdmin::PENDING->value,
                    strtolower(RequestStatusAdmin::RESOLVED->name) => RequestStatusAdmin::RESOLVED->value,
                    default => '',
                }),
            ExportColumn::make('status.name')
                ->label('Décision'),
            ExportColumn::make('decision_date')
                ->label('Date de décision'),
            ExportColumn::make('decision_comments')
                ->label('Commentaire relatif à la décision'),
            ExportColumn::make('contacts')
                ->label('Personnes ressources')
                ->formatStateUsing(function (?array $state): string {
                    return $state ? implode(' ', $state) : '';
                }),
            ExportColumn::make('file')
                ->label('Document'),
            ExportColumn::make('user.name')
                ->label('Utilisateur'),
            ExportColumn::make('type')
                ->label('Type')
                ->formatStateUsing(fn (?string $state): string => implode(', ', array_map(fn ($word) => match (strtolower($word)) {
                    strtolower(RequestType::TRAINING->name) => RequestType::TRAINING->value,
                    strtolower(RequestType::ANALYSIS->name) => RequestType::ANALYSIS->value,
                    strtolower(RequestType::TECHNICAL_ACTION->name) => RequestType::TECHNICAL_ACTION->value,
                    default => '-',
                }, explode(', ', $state)))),
            ExportColumn::make('trainingObjectives.name')
                ->label('Objectifs (formation)'),
            ExportColumn::make('analysisObjectives.name')
                ->label('Objectifs (analyse)'),
            ExportColumn::make('created_at')
                ->label('Date de création'),
            ExportColumn::make('updated_at')
                ->label('Date de modification'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'L\'exportation de vos demandes est terminée ('.number_format($export->successful_rows).').';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' enregistrement(s) non exporté(s).';
        }

        return $body;
    }
}
