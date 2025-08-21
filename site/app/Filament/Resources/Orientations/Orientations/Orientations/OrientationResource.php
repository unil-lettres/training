<?php

namespace App\Filament\Resources\Orientations\Orientations\Orientations;

use App\Filament\Exports\OrientationExporter;
use App\Filament\Resources\Orientations\Pages\CreateOrientation;
use App\Filament\Resources\Orientations\Pages\EditOrientation;
use App\Filament\Resources\Orientations\Pages\ListOrientations;
use App\Filament\Resources\Orientations\Pages\ViewOrientation;
use App\Models\Orientation;
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

class OrientationResource extends Resource
{
    protected static ?string $model = Orientation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-viewfinder-circle';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Orientation';

    protected static string|\UnitEnum|null $navigationGroup = 'Listes';

    protected static ?int $navigationSort = 7;

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
                        ->exporter(OrientationExporter::class),
                ]),
            ]);
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
            'index' => ListOrientations::route('/'),
            'create' => CreateOrientation::route('/create'),
            'view' => ViewOrientation::route('/{record}'),
            'edit' => EditOrientation::route('/{record}/edit'),
        ];
    }
}
