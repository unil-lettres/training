<?php

namespace App\Filament\Resources;

use App\Filament\Exports\FundingExporter;
use App\Filament\Resources\FundingResource\Pages\CreateFunding;
use App\Filament\Resources\FundingResource\Pages\EditFunding;
use App\Filament\Resources\FundingResource\Pages\ListFundings;
use App\Filament\Resources\FundingResource\Pages\ViewFunding;
use App\Models\Funding;
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

class FundingResource extends Resource
{
    protected static ?string $model = Funding::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'financement';

    protected static string|\UnitEnum|null $navigationGroup = 'Listes';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                        ->exporter(FundingExporter::class),
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
            'index' => ListFundings::route('/'),
            'create' => CreateFunding::route('/create'),
            'view' => ViewFunding::route('/{record}'),
            'edit' => EditFunding::route('/{record}/edit'),
        ];
    }
}
