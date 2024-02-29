<?php

namespace App\Filament\Resources\TeacherResearchResource\Pages;

use App\Filament\Resources\TeacherResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeacherResearch extends EditRecord
{
    protected static string $resource = TeacherResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
