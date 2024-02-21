<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\College;
use App\Models\Department;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\isNull;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup="Academic";


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
           ->with(["department", "department.college"]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")
                    ->string()
                    ->required(),
                TextInput::make("description")
                    ->string()
                    ->required(),

                Select::make("academic_degree")
                    ->label("academic_degree")
                    ->options([
                        'diploma'=>'diploma',
                        'bachelor'=>'bachelor',
                        'master'=>'master',
                        'doctoral'=>'doctoral',
                    ])
                    ->required()
                    ->searchable(),

                Select::make("college_id")
                    ->label("collage")
                    ->options(College::all()->pluck("name", "id"))
                    ->reactive()
                    ->searchable(),

                Select::make("department_id")
                    ->label("department")
                    ->options(fn(Get $get): Collection => Department::query()
                        ->when($get('collage_id'),function ($query) use ($get) {
                            return $query->where("college_id", $get('collage_id'));
                        })
                        ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('academic_degree')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('department.name'),
                TextColumn::make('college.name'),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship("department","name"),

                SelectFilter::make('college')
                    ->relationship("college","name"),



                SelectFilter::make('academic_degree')
                    ->options([
                        'diploma'=>'diploma',
                        'bachelor'=>'bachelor',
                        'master'=>'master',
                        'doctoral'=>'doctoral',                    ]),
            ])
            ->actions([
                ViewAction::make('view')
                    ->button(),

                EditAction::make('edit')
                    ->button(),

                Tables\Actions\DeleteAction::make('delete')
                    ->button(),            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
