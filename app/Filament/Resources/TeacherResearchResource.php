<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResearchResource\Pages;
use App\Filament\Resources\TeacherResearchResource\RelationManagers;
use App\Models\Research;
use App\Models\TeacherResearch;
use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Termwind\Enums\Color;
use function Laravel\Prompts\text;
use function PHPUnit\Framework\isNull;
use function Psy\debug;

class TeacherResearchResource extends Resource
{
    protected static ?string $model = Research::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where("teacher_id", auth()->id()); // TODO: Change the autogenerated stub
    }

    public static function canAccess(): bool
    {
        return auth()->user()->role_id == 3; // TODO: Change the autogenerated stub
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make("title")
                            ->string()
                            ->disabledOn("edit")
                            ->required(),
                        TextInput::make("description")
                            ->string()
                            ->disabledOn("edit")
                            ->required(),
                        TextInput::make("abstract")
                            ->string()
                            ->disabledOn("edit")
                            ->hiddenOn("create"),

                        Forms\Components\Select::make("student_id")
                            ->label("student")
                            ->options(function ($get, $livewire) {
                                $query = User::query()
                                    ->where('role_id', 2)
                                    ->where('subject_id', auth()->user()->subject_id);
                                if ($livewire instanceof CreateRecord) {
                                    $query->doesntHave('researchesAsStudent');
                                }

                                return $query->pluck('name', 'id');
                            })
                            ->disabledOn("edit")
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make("administer_id")
                            ->label("Administrator")
                            ->options(fn(Get $get): Collection => User::query()
                                ->where("role_id", "=", 4)
                                ->where("college_id", auth()->user()->college_id)
                                ->pluck("name", "id")
                            )
                            ->required()
                            ->native(false),

                    ])->columns(2),

               Forms\Components\Section::make()
                ->schema([
                    DateTimePicker::make("prepared_at")
                        ->string()
                        ->disabledOn("edit")
                        ->hiddenOn("create"),


                    TextInput::make("marks")
                        ->default(0)
                        ->minValue(0)
                        ->maxValue(100)
                        ->hiddenOn("create")
                        ->reactive()
                        ->integer()
                    ->required(),

                    TextInput::make("comments")
                        ->hiddenOn("create")
                        ->string()
                    ->required(),
                    Forms\Components\Select::make('status')
                        ->options(fn(callable $get) => $get('marks') >= 50 ? ['under_evaluate' => 'under_evaluate'] : ['reject' => 'reject'])
                        ->default('reject')
                        ->native(false)
                        ->hiddenOn("create")
                    ->required()
                ])->columns(2)->hiddenOn("create")


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'progress' => 'info',
                        'under_review' => 'gray',
                        'under_evaluate' => 'warning',
                        'publish' => 'success',
                        'reject' => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('marks')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('college.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button()
                    ->label("give marks")
                    ->iconSize('lg')
                    ->disabled(fn(Research $record) => $record->status != "under_review"),

                Tables\Actions\Action::make("files.download")
                    ->icon('heroicon-o-folder-arrow-down')
                    ->url(fn(Research $record) => route("files.download", $record))
                    ->button()
                    ->iconSize('lg')
                    ->color("info")
                    ->disabled(fn(Research $record) => $record->status == "progress")
            ])
            ->recordUrl(null)
            ->recordAction(Tables\Actions\ViewAction::class);
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
            'index' => Pages\ListTeacherResearch::route('/'),
            'create' => Pages\CreateTeacherResearch::route('/create'),
            'edit' => Pages\EditTeacherResearch::route('/{record}/edit'),
        ];
    }
}
