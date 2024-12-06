<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TrainingExporter;
use App\Filament\Resources\TrainingResource\Pages\CreateTraining;
use App\Filament\Resources\TrainingResource\Pages\EditTraining;
use App\Filament\Resources\TrainingResource\Pages\ListTrainings;
use App\Filament\Resources\TrainingResource\Pages\ViewTraining;
use App\Models\Training;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'formation';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 2;

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
                        RichEditor::make('description')
                            ->label('Description')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])->columnSpanFull(),
                        DateTimePicker::make('start')
                            ->label('Début')
                            ->displayFormat('j M Y, H:i')
                            ->native(false),
                        DateTimePicker::make('end')
                            ->label('Fin')
                            ->displayFormat('j M Y, H:i')
                            ->native(false),
                        Toggle::make('visible')
                            ->label('Visible'),
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
                TextColumn::make('start')
                    ->label('Début')
                    ->dateTime('j M Y, H:i')
                    ->sortable(),
                TextColumn::make('end')
                    ->label('Fin')
                    ->dateTime('j M Y, H:i')
                    ->sortable(),
                IconColumn::make('visible')
                    ->label('Visible?')
                    ->boolean(),
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
            ])->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('visible')
                    ->label('Visibilité')
                    ->placeholder('-')
                    ->trueLabel('Visible')
                    ->falseLabel('Non-visible')
                    ->queries(
                        true: fn (Builder $query) => $query->where('visible', true),
                        false: fn (Builder $query) => $query->where('visible', false),
                        blank: fn (Builder $query) => $query,
                    ),
            ])
            ->actions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label(''),
                ReplicateAction::make()
                    ->label(''),
                DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(TrainingExporter::class),
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
            'index' => ListTrainings::route('/'),
            'create' => CreateTraining::route('/create'),
            'view' => ViewTraining::route('/{record}'),
            'edit' => EditTraining::route('/{record}/edit'),
        ];
    }
}
