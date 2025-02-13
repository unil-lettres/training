<?php

namespace App\Filament\Resources;

use App\Enums\RequestStatusAdmin;
use App\Enums\RequestType;
use App\Filament\Exports\RequestExporter;
use App\Filament\Resources\RequestResource\Pages\CreateRequest;
use App\Filament\Resources\RequestResource\Pages\EditRequest;
use App\Filament\Resources\RequestResource\Pages\ListRequests;
use App\Filament\Resources\RequestResource\Pages\ViewRequest;
use App\Models\Request;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'demande';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 1;

    private static array $toolbarButtons = [
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
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')->tabs([
                    Tab::make('Champs communs')->schema([
                        TextInput::make('name')
                            ->label('Libellé')
                            ->required()
                            ->maxLength(150),
                        RichEditor::make('description')
                            ->label('Description')
                            ->toolbarButtons(RequestResource::$toolbarButtons),
                        DatePicker::make('filling_date')
                            ->label('Date dépot')
                            ->displayFormat('j M Y')
                            ->native(false),
                        TextInput::make('applicants')
                            ->label('Demandeur(s)')
                            ->maxLength(300)
                            ->default(null),
                        TextInput::make('theme')
                            ->label('Thème')
                            ->maxLength(300)
                            ->default(null),
                        DatePicker::make('deadline')
                            ->label('Délai production')
                            ->displayFormat('j M Y')
                            ->native(false),
                        TextInput::make('level')
                            ->label('Niveau requis')
                            ->maxLength(300)
                            ->default(null),
                        RichEditor::make('comments')
                            ->label('Remarques')
                            ->toolbarButtons(RequestResource::$toolbarButtons),
                        TextInput::make('contact')
                            ->label('Mail contact')
                            ->maxLength(300)
                            ->default(null),

                        Section::make('Chercheur/doctorant')
                            ->collapsed()
                            ->schema([
                                TextInput::make('extras.doctoral_school')
                                    ->label('École doctorale')
                                    ->maxLength(300)
                                    ->default(null),
                                Toggle::make('extras.fns')
                                    ->label('Fns'),
                                TextInput::make('extras.doctoral_status')
                                    ->label('Doctorat statut')
                                    ->maxLength(300)
                                    ->default(null),
                                TextInput::make('extras.doctoral_level')
                                    ->label('Niveau actuel')
                                    ->maxLength(300)
                                    ->default(null),
                                TextInput::make('extras.tested_products')
                                    ->label('Produits testés')
                                    ->maxLength(300)
                                    ->default(null),
                            ]),

                        Section::make('Enseignant')
                            ->collapsed()
                            ->schema([
                                Toggle::make('extras.teachers_nbr')
                                    ->label('Seul ou avec d\'autres enseignants'),
                                Toggle::make('extras.students_nbr')
                                    ->label('Avec un ou des étudiants'),
                                Toggle::make('extras.action_type')
                                    ->label('Intervention pour toute une classe, pendant les cours'),
                            ]),

                        Section::make('Administration')
                            ->collapsed()
                            ->schema([
                                Select::make('status_admin')
                                    ->label('Statut')
                                    ->options(RequestStatusAdmin::toArray())
                                    ->default(strtolower(RequestStatusAdmin::NEW->name)),
                                Select::make('status_id')
                                    ->label('Décision')
                                    ->relationship('status', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nom')
                                            ->required()
                                            ->maxLength(150),
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->default(null),
                                DatePicker::make('decision_date')
                                    ->label('Date de décision')
                                    ->displayFormat('j M Y')
                                    ->native(false),
                                RichEditor::make('decision_comments')
                                    ->label('Commentaire relatif à la décision')
                                    ->toolbarButtons(RequestResource::$toolbarButtons),
                                Select::make('orientation_id')
                                    ->label('Orientation')
                                    ->relationship('orientation', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nom')
                                            ->required()
                                            ->maxLength(150),
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->default(null),
                                Repeater::make('contacts')
                                    ->label('Personnes ressources')
                                    ->schema([
                                        TextInput::make('contact')
                                            ->label('Contact')
                                            ->maxLength(150)
                                            ->default(null),
                                        Textarea::make('notes')
                                            ->label('Notes')
                                            ->maxLength(300)
                                            ->default(null),
                                    ])
                                    ->columns(2),
                                FileUpload::make('file')
                                    ->label('Document')
                                    ->disk('public')
                                    ->directory('uploads')
                                    ->maxSize(10000)
                                    ->previewable(false)
                                    ->openable()
                                    ->downloadable(),
                                Select::make('user_id')
                                    ->label('Utilisateur')
                                    ->relationship('user', 'name')
                                    ->default(null),
                                Select::make('type')
                                    ->label('Type(s)')
                                    ->multiple()
                                    ->options(RequestType::toArray())
                                    ->default(null),
                            ]),
                    ]),

                    Tab::make('Formation')->schema([
                        Select::make('request_training_objective')
                            ->label('Objectif(s)')
                            ->multiple()
                            ->relationship(name: 'trainingObjectives', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),

                        Select::make('request_training_tool')
                            ->label('Outil(s)')
                            ->multiple()
                            ->relationship(name: 'trainingTools', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),
                    ]),

                    Tab::make('Analyse')->schema([
                        Select::make('request_analysis_objective')
                            ->label('Objectif(s)')
                            ->multiple()
                            ->relationship(name: 'analysisObjectives', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),

                        Select::make('request_funding')
                            ->label('Financement(s)')
                            ->multiple()
                            ->relationship(name: 'fundings', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),
                    ]),

                    Tab::make('Action technique')->schema([
                        Select::make('request_intervention')
                            ->label('Intervention(s)')
                            ->multiple()
                            ->relationship(name: 'interventions', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),

                        Select::make('request_technical_action_tool')
                            ->label('Outil(s)')
                            ->multiple()
                            ->relationship(name: 'technicalActionTools', titleAttribute: 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(150),
                            ])
                            ->searchable()
                            ->preload()
                            ->default(null),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Libellé')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('filling_date')
                    ->label('Date dépot')
                    ->dateTime('j M Y')
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label('Décision')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type(s)')
                    ->formatStateUsing(fn (?string $state): string => implode(', ', array_map(fn ($word) => match (strtolower($word)) {
                        strtolower(RequestType::TRAINING->name) => RequestType::TRAINING->value,
                        strtolower(RequestType::ANALYSIS->name) => RequestType::ANALYSIS->value,
                        strtolower(RequestType::TECHNICAL_ACTION->name) => RequestType::TECHNICAL_ACTION->value,
                        default => '-',
                    }, explode(', ', $state)))),
                TextColumn::make('status_admin')
                    ->label('Statut')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        strtolower(RequestStatusAdmin::NEW->name) => RequestStatusAdmin::NEW->value,
                        strtolower(RequestStatusAdmin::PENDING->name) => RequestStatusAdmin::PENDING->value,
                        strtolower(RequestStatusAdmin::PLANNED->name) => RequestStatusAdmin::PLANNED->value,
                        strtolower(RequestStatusAdmin::IN_PROGRESS->name) => RequestStatusAdmin::IN_PROGRESS->value,
                        strtolower(RequestStatusAdmin::RESOLVED->name) => RequestStatusAdmin::RESOLVED->value,
                        default => '',
                    })
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(80)
                    ->html()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('comments')
                    ->label('Remarques')
                    ->limit(80)
                    ->html()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('trainingObjectives.name')
                    ->label('Objectif(s) (formation)')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('analysisObjectives.name')
                    ->label('Objectif(s) (analyse)')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                DateRangeFilter::make('deadline')
                    ->label('Délai de production')
                    ->disableClear(),
                SelectFilter::make('status_admin')
                    ->label('Statut')
                    ->options(RequestStatusAdmin::toArray()),
                SelectFilter::make('status')
                    ->label('Décision')
                    ->searchable()
                    ->preload()
                    ->relationship('status', 'name'),
                SelectFilter::make('type')
                    ->label('Type(s)')
                    ->options(RequestType::toArray())
                    ->query(function (Builder $query, $state) {
                        if (! empty($state['value'])) {
                            return $query->where(
                                'type', 'LIKE', '%"'.$state['value'].'"%'
                            );
                        }

                        return $query;
                    }),
                SelectFilter::make('request_training_objective')
                    ->label('Objectif(s) (formation)')
                    ->searchable()
                    ->preload()
                    ->relationship('trainingObjectives', 'name'),
                SelectFilter::make('request_analysis_objective')
                    ->label('Objectif(s) (analyse)')
                    ->searchable()
                    ->preload()
                    ->relationship('analysisObjectives', 'name'),
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
                        ->exporter(RequestExporter::class),
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
            'index' => ListRequests::route('/'),
            'create' => CreateRequest::route('/create'),
            'view' => ViewRequest::route('/{record}'),
            'edit' => EditRequest::route('/{record}/edit'),
        ];
    }
}
