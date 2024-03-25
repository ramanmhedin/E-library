<?php

namespace App\Livewire;

use App\Models\College;
use App\Models\Department;
use App\Models\Research;
use App\Models\Subject;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Livewire\Component;
use function PHPUnit\Framework\isNull;

class PublishedResearch extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function render(): View
    {
        return view('livewire.published-research');
    }

    public static function form(Form $form): Form
    {
        return $form
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
                    ->required(),
                FileUpload::make('research.files')
                    ->label('Research Documentation')
                    ->multiple()
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->hiddenOn("view")
                    ->required()
                    ->disk('public'),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->configure()
            ->query(Research::query()->where('status', 'publish'))
            ->contentGrid([])
            ->columns([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Panel::make([
                            Split::make([
                                TextColumn::make('title')
                                    ->size(TextColumn\TextColumnSize::Large)
                                    ->weight(FontWeight::ExtraBold)
                                    ->fontFamily(FontFamily::Serif)
                                    ->searchable()
                                    ->sortable(),
                            ])

                        ])->columnSpan(2),
                        TextColumn::make("description")
                            ->columnSpan(2),

                        TextColumn::make('student.name')
                            ->prefix(fn() => new HtmlString('<b class="text-lg bg-amber-5" style="color: rgb(245,158,11) !important;" href="/terms" >Student : </b>'))
                            ->size(TextColumn\TextColumnSize::Medium)
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('subject.name')
                            ->prefix(fn() => new HtmlString('<b class="text-lg bg-amber-5" style="color: rgb(245,158,11) !important;" href="/terms" >Subject : </b>'))
                            ->size(TextColumn\TextColumnSize::Medium)
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),

                        TextColumn::make('college.name')
                            ->searchable()
                            ->sortable()
                            ->size(TextColumn\TextColumnSize::Medium)
                            ->weight(FontWeight::Bold)
                            ->formatStateUsing(function ($state, Research $research) {
                                return $research->college->name . " / " . $research->subject->department->name;
                            }),


                        TextColumn::make('marks')
                            ->prefix(fn() => new HtmlString('<b class="text-lg bg-amber-5" style="color: rgb(245,158,11) !important;" href="/terms" >marks : </b>'))
                            ->size(TextColumn\TextColumnSize::Medium)
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),
                    ]),


            ])
            ->filters([
                Filter::make('filter')->form([
                    Select::make('college_id')
                        ->label("college")
                        ->options(College::query()->pluck("name", "id"))
                        ->native()
                        ->reactive(),

                    Select::make('department_id')
                        ->label("department")
                        ->options(function (Get $get) {
                            if (!empty($get("college_id"))) {
                                return Department::query()->where("college_id", $get("college_id"))->pluck("name", "id");
                            }
                            return Department::query()->pluck("name", "id");
                        })
                        ->native()
                        ->reactive(),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
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

                })->indicateUsing(function (array $data) {
                    $indicators = [];

                    if (isset($data['college_id']) && $college = College::find($data['college_id'])) {
                        $indicators['College'] = $college->name;
                    }

                    if (isset($data['department_id']) && $department = Department::find($data['department_id'])) {
                        $indicators['Department'] = $department->name;
                    }

                    return $indicators;
                }),
            ])
            ->recordTitle("Research")
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 2,

            ])
            ->actions(
                [
                    ViewAction::make()->model(Research::class)
                        ->button()
                        ->form([
                            Group::make([
                                Section::make("Research information")
                                    ->schema([
                                        TextInput::make("title")
                                            ->string()
                                            ->required(),
                                        TextInput::make("description")
                                            ->string()
                                            ->required(),
                                        TextInput::make("abstract")
                                            ->string(),
                                        FileUpload::make('research.files')
                                            ->label('Research Documentation')
                                            ->multiple()
                                            ->preserveFilenames()
                                            ->openable()
                                            ->downloadable()
                                            ->hiddenOn("view")
                                            ->disk('public'),// Ensure you're specifying the correct disk

                                    ])->columns(2),
                                Section::make("Student")
                                    ->schema([
                                        Select::make("college_id")
                                            ->label("college")
                                            ->options(College::all()->pluck("name", "id"))
                                            ->reactive()
                                            ->searchable()
                                            ->required(),

                                        Select::make("subject_id")
                                            ->label("subject")
                                            ->options(fn(Get $get): Collection => Subject::query()
                                                ->when(isNull($get('college_id')), function ($query) use ($get) {
                                                    return $query->where("college_id", $get('college_id'));
                                                })->pluck("name", "id")
                                            )
                                            ->reactive()
                                            ->searchable()
                                            ->required(),
                                        Select::make("student_id")
                                            ->label("student")
                                            ->options(fn(Get $get): Collection => User::query()
                                                ->where("role_id", "=", 2)
                                                ->when(isNull($get('subject_id')), function ($query) use ($get) {

                                                    return $query->where("subject_id", $get('subject_id'));

                                                })->pluck("name", "id")
                                            )
                                            ->required(),

                                        DateTimePicker::make("prepared_at")
                                            ->string()
                                            ->required(),
                                    ])->columns(2),
                                Section::make("Supervisor")
                                    ->schema([

                                        Group::make([
                                            Select::make("teacher_id")
                                                ->label("teacher")
                                                ->options(fn(Get $get): Collection => User::query()
                                                    ->where("role_id", "=", 3)
                                                    ->when(isNull($get('subject_id')), function ($query) use ($get) {

                                                        return $query->where("subject_id", $get('subject_id'));

                                                    })->pluck("name", "id")
                                                )
                                                ->required(),
                                            TextInput::make("marks")
                                                ->minValue(0)
                                                ->integer(),
                                            TextInput::make("comments")
                                                ->string(),
                                        ]),
                                    ]),
                                Section::make("Administrator")
                                    ->schema
                                    ([
                                        Select::make("administer_id")
                                            ->label("President")
                                            ->options(fn(Get $get): Collection => User::query()
                                                ->where("role_id", "=", 4)
                                                ->when(isNull($get('college_id')), function ($query) use ($get) {
                                                    return $query
                                                        ->where("college_id", $get('college_id'));
                                                })->pluck("name", "id")
                                            )
                                            ->required(),
                                        DateTimePicker::make("administer_answered_at")
                                            ->label("President_result")
                                            ->string(),

                                        Group::make([
                                            TextInput::make("plagiarism_percentage")
                                                ->integer()
                                                ->prefix(" % ")
                                                ->maxValue(100)
                                                ->minValue(0),
                                            TextInput::make("impact_factor")
                                                ->label("impact factor")
                                                ->numeric()
                                                ->inputMode("decimal")
                                                ->step(0.1)
                                                ->maxValue(0.6)
                                                ->minValue(0.0),
                                        ])->columns(2),

                                        Select::make("status")
                                            ->options(["progress" => "progress", "under_review" => "under_review", "under_evaluate" => "under_evaluate", "publish" => "publish", "reject" => "reject"])
                                            ->required()
                                            ->native(),
                                    ])->columns(2)

                            ])->columnSpan(2),
                        ]),

                    \Filament\Tables\Actions\Action::make("files.download")
                        ->url(fn(Research $record) => route("files.download", $record))
                        ->button()
                        ->size("lg")
                        ->color("info")
                        ->disabled(fn(Research $record) => $record->status == "progress")
                ]
            );


    }

    public static function getPages(): array
    {
        return [

            'view' => route('/home/{record}'),
        ];
    }
}
