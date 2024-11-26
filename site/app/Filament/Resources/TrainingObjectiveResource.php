<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TrainingObjectiveExporter;
use App\Filament\Resources\TrainingObjectiveResource\Pages\CreateTrainingObjective;
use App\Filament\Resources\TrainingObjectiveResource\Pages\EditTrainingObjective;
use App\Filament\Resources\TrainingObjectiveResource\Pages\ListTrainingObjectives;
use App\Filament\Resources\TrainingObjectiveResource\Pages\ViewTrainingObjective;
use App\Models\TrainingObjective;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingObjectiveResource extends Resource
{
    protected static ?string $model = TrainingObjective::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'objectifs (formation)';

    protected static ?string $navigationGroup = 'Thésaurus';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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
            ->actions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label(''),
                DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
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
