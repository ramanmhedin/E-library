<?php

namespace App\Filament\Resources\PresidentResearchResource\Pages;

use App\Filament\Resources\PresidentResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresidentResearch extends ListRecords
{
    protected static string $resource = PresidentResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
