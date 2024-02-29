<?php

namespace App\Filament\Resources\TeacherResearchResource\Pages;

use App\Filament\Resources\TeacherResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeacherResearch extends ListRecords
{
    protected static string $resource = TeacherResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
