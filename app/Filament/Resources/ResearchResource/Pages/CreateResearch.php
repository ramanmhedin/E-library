<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use App\Models\Research;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateResearch extends CreateRecord
{
    protected static string $resource = ResearchResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();
        $record =  static::getModel()::create($data);

        foreach ($data['research']["files"] ?? [] as $filePath) {
            // Extract the file name from the path
            $fileName = basename($filePath);
            // Generate a unique file name to prevent overwriting
            $uniqueFileName = Str::uuid()->toString() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

            // Define the final storage location
            $finalStoragePath = 'research/files/' . $uniqueFileName;

            // Move the file from the temporary location to the final location
            Storage::disk('public')->move($filePath, $finalStoragePath);

            // Create File model instance associated with the Research
            // Here, use $record as the Research model instance
            $record->files()->create([
                'original_name' => $fileName, // Original file name
                'file_name' => $uniqueFileName, // Unique file name
                'path' => $finalStoragePath, // Storage path of the file
                'mime_type' => Storage::disk('public')->mimeType($finalStoragePath), // Get MIME type of the file
            ]);
        }

        DB::commit();

        return $record; // TODO: Change the autogenerated stub
    }


}
