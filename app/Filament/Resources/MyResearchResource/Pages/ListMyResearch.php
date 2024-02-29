<?php

namespace App\Filament\Resources\MyResearchResource\Pages;

use App\Filament\Resources\MyResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyResearch extends ListRecords
{
    protected static string $resource = MyResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
