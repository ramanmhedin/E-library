<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListResearch extends ListRecords
{
    protected static string $resource = ResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
//info
//gray
//warning
//success
//danger
    public function getTabs(): array
    {
        $tabs = [];
        $tabs["All"] = Tab::make('All')
            ->badge(parent::getTableQuery()->count());

        $tabs["Progress"] = Tab::make('Progress')
            ->query(fn($query) => $query->where('status', 'progress'))
            ->badge(parent::getTableQuery()->where('status', 'progress')->count())
        ->badgeColor("info");

        $tabs["Under Review"] = Tab::make('Under Review')
            ->query(fn($query) => $query->where('status', 'under_review'))
            ->badge(parent::getTableQuery()->where('status', 'under_review')->count())
        ->badgeColor("gray");

        $tabs["Under Evaluate"] = Tab::make('Under Evaluate')
            ->query(fn($query) => $query->where('status', 'under_evaluate'))
            ->badge(parent::getTableQuery()->where('status', 'under_evaluate')->count())
        ->badgeColor("warning");

        $tabs["Publish"] = Tab::make('Publish')
            ->query(fn($query) => $query->where('status', 'publish'))
            ->badge(parent::getTableQuery()->where('status', 'publish')->count())
        ->badgeColor("success");

        $tabs["Reject"] = Tab::make('Reject')
            ->query(fn($query) => $query->where('status', 'reject'))
            ->badge(parent::getTableQuery()->where('status', 'reject')->count())
        ->badgeColor("danger");

        return $tabs;
    }
}
