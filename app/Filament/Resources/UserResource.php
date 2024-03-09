<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\College;
use App\Models\Department;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isNull;


class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = "Staff";

    public static function canAccess(): bool
    {
        return auth()->user()->role->name == "Admin" || auth()->user()->role->name == "President"; // TODO: Change the autogenerated stub
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->role_id == 4) {
            return parent::getEloquentQuery()->with(["role","subject","college","department"])->where("college_id", auth()->user()->college_id);
        }
        return parent::getEloquentQuery(); // TODO: Change the autogenerated stub
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


    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Section::make("Profile")
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make("user_name")
                                    ->string()
                                    ->required(),
                                TextInput::make("name")
                                    ->string()
                                    ->required(),
                                TextInput::make("age")
                                    ->nullable()
                                    ->maxLength(100)
                                    ->minLength(0)
                                    ->required(),
                            ])->columns(3),

                        TextInput::make("email")
                            ->email()
                            ->required(),

                        TextInput::make("password")
                            ->password()
                            ->required(fn($livewire) => is_null($livewire->record?->getKey() ?? null))
                            ->revealable()
                            ->dehydrateStateUsing(function ($state, $livewire) {
                                // Only hash and update the password if a new one is provided
                                if (!empty($state)) {
                                    return Hash::make($state);
                                }

                                // If no new password is provided, return the existing password from the model
                                // This prevents the password field from being updated with a null value
                                return $livewire->record->password;
                            })
                            ->hiddenOn("view"),

                    ])->columnSpan(2),

                Forms\Components\Group::make([
                    Section::make("Role")->schema([
                        Select::make("role_id")
                            ->label("role")
                            ->options(Role::all()->pluck("name", "id"))
                            ->searchable()
                            ->required()
                            ->reactive(),
                    ]),

                    Section::make("Academic")
                        ->schema([
                            Group::make(
                                [
                                    Select::make("college_id")
                                        ->label("college")
                                        ->options(College::all()->pluck("name", "id"))
                                        ->reactive()
                                        ->searchable(),

                                    Select::make("department_id")
                                        ->label("department")
                                        ->options(fn(Get $get): Collection => Department::query()
                                            ->when(isNull($get('college_id')), function ($query) use ($get) {
                                                return $query->
                                                where("college_id", $get('college_id'));
                                            })
                                            ->pluck("name", "id")
                                        )
                                        ->hidden(fn($get) => $get('role_id') == 4)
                                        ->required()
                                        ->searchable(),

                                    Select::make("subject_id")
                                        ->label("subject")
                                        ->options(fn(Get $get): Collection => Subject::query()
                                            ->when($get('department_id'), function ($query) use ($get) {
                                                return $query->where("department_id", $get("department_id"));
                                            })
                                            ->pluck("name", "id")
                                        )
                                        ->hidden(fn($get) => $get('role_id') == 4)
                                        ->required()
                                        ->reactive()
                                        ->searchable(),
                                ]
                            )->hidden(fn($get) => $get('role_id') == 1 || $get('role_id') == null)

                        ])
                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('age')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role.name'),
                TextColumn::make('college.name'),
                TextColumn::make('department.name'),

                TextColumn::make('subject.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make("filter")->form([
                    Select::make('role_id')
                        ->label("role")
                        ->native()
                        ->relationship("role", "name"),

                    Select::make('college_id')
                        ->label("college")
                        ->hidden(fn() => auth()->user()->role_id == 4)
                        ->relationship("college", "name")
                        ->native()
                        ->reactive(),

                    Select::make('department_id')
                        ->label("department")
                        ->options(function (Get $get) {
                            $department = Department::query();

                            if ($get("college_id") !== null)
                                $department->where("college_id", $get("college_id"));

                            if (auth()->user()->role_id == 4)
                                $department->where("college_id", auth()->user()->college_id);

                            return $department->pluck("name", "id");
                        })
                ])  ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['role_id'],
                            fn(Builder $query, $date): Builder => $query->where('role_id', $date),
                        )->when(
                            $data['college_id'],
                            fn(Builder $query, $date): Builder => $query->where('college_id', $date),
                        )
                        ->when(
                            $data['department_id'],
                            function (Builder $query, $departmentId) {
                                // This assumes there's a 'subject' relation on Research that links to a 'department'
                                return $query->whereHas('subject', function (Builder $q) use ($departmentId) {
                                    $q->where('department_id', $departmentId);
                                });
                            }
                        );

                })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];

                        if (isset($data['role_id']) && $role = Role::find($data['role_id'])) {
                            $indicators['Role'] = $role->name;
                        }

                        if (isset($data['college_id']) && $college = College::find($data['college_id'])) {
                            $indicators['College'] = $college->name;
                        }

                        if (isset($data['department_id']) && $department = Department::find($data['department_id'])) {
                            $indicators['Department'] = $department->name;
                        }

                        return $indicators;
                    })

            ])
            ->actions([
                ViewAction::make('view')
                    ->button(),

                EditAction::make('edit')
                    ->button(),

                Tables\Actions\DeleteAction::make('delete')
                    ->button(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
