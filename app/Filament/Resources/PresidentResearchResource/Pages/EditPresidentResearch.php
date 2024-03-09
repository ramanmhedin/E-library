<?php

namespace App\Filament\Resources\PresidentResearchResource\Pages;

use App\Filament\Resources\PresidentResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresidentResearch extends EditRecord
{
    protected static string $resource = PresidentResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
