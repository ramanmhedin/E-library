<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollegeResource\Pages;
use App\Filament\Resources\CollegeResource\RelationManagers;
use App\Models\College;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollegeResource extends Resource
{
    protected static ?string $model = College::class;
    public static function canAccess(): bool
    {
        return auth()->user()->role->name == "Admin" || auth()->user()->role->name == "President"; // TODO: Change the autogenerated stub
    }
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup="Academic";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")
                    ->string()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->searchable()
                ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()->columnSpan(2),
            ])
            ->filters([

                ])
            ->actions([
                ViewAction::make('view')
                    ->button(),

                EditAction::make('edit')
                    ->button(),

                DeleteAction::make('delete')
                    ->button(),])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListColleges::route('/'),
            'create' => Pages\CreateCollege::route('/create'),
            'edit' => Pages\EditCollege::route('/{record}/edit'),
        ];
    }
}
