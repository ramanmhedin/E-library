<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\College;
use App\Models\Department;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;
    public static function canAccess(): bool
    {
        return auth()->user()->role->name == "Admin" || auth()->user()->role->id==4; // TODO: Change the autogenerated stub
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role->name == "Admin"; // TODO: Change the autogenerated stub
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role->name == "Admin"; // TODO: Change the autogenerated stub
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role->name == "Admin"; // TODO: Change the autogenerated stub
    }
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup="Academic";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")
                    ->string()
                    ->required(),
                Select::make("college_id")
                    ->label("College")
                    ->options(College::all()->pluck("name","id"))
                    ->searchable()
                    ->required()
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()->columnSpan(2),
                TextColumn::make('college.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('college_id')
                    ->relationship("college","name"),            ])
            ->actions([

                EditAction::make('edit')
                    ->button(),

                DeleteAction::make('delete')
                    ->button(),
                ])
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
