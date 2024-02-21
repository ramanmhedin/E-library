<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResearch extends EditRecord
{
    protected static string $resource = ResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        $research = $this->record; // Get the current Research model
        return [
            \Filament\Widgets\ViewWidget::make()
                ->view('components.research-files', ['files' => $research->files])
                ->columnSpan([
                    'sm' => 2,
                ]),
        ];
    }
}
