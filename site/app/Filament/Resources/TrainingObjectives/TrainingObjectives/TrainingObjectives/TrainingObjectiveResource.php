<?php

namespace App\Filament\Resources\TrainingObjectives\TrainingObjectives\TrainingObjectives;

use App\Filament\Exports\TrainingObjectiveExporter;
use App\Filament\Resources\TrainingObjectives\Pages\CreateTrainingObjective;
use App\Filament\Resources\TrainingObjectives\Pages\EditTrainingObjective;
use App\Filament\Resources\TrainingObjectives\Pages\ListTrainingObjectives;
use App\Filament\Resources\TrainingObjectives\Pages\ViewTrainingObjective;
use App\Models\TrainingObjective;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingObjectiveResource extends Resource
{
    protected static ?string $model = TrainingObjective::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'objectifs (formation)';

    protected static string|\UnitEnum|null $navigationGroup = 'Listes';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(150),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime('j M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Date de modification')
                    ->dateTime('j M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('name', 'asc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label(''),
                DeleteAction::make()
                    ->label(''),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(TrainingObjectiveExporter::class),
                ]),
            ])->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingObjectives::route('/'),
            'create' => CreateTrainingObjective::route('/create'),
            'view' => ViewTrainingObjective::route('/{record}'),
            'edit' => EditTrainingObjective::route('/{record}/edit'),
        ];
    }
}
