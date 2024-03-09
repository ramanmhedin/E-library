<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use App\Models\Research;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditResearch extends EditRecord
{
    protected static string $resource = ResearchResource::class;
    protected static ?string $title = null;

    public function __construct()
    {
        self::$title = self::getMyTitle();
    }


    public static function getMyTitle(): string
    {
        if (auth()->user()->role_id == 4)
        {
            return "evaluating research";
        }
            return "Edit Research";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
