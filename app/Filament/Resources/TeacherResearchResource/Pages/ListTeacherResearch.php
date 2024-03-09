<?php

namespace App\Filament\Resources\TeacherResearchResource\Pages;

use App\Filament\Resources\TeacherResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeacherResearch extends ListRecords
{
    protected static string $resource = TeacherResearchResource::class;

//    protected function getTableActions(): array
//    { return [
//        // This action opens the edit form in a modal
////        Actions\ViewAction::make('edit')
////            ->form([
////                // Define the form fields here, similar to what you have in the edit form
////                // This can be auto-populated based on the resource definition
////            ])
////            ->modalHeading('Edit Record')
////            ->action(function ($record, $data) {
////                // Action to perform on modal form submission, typically updating the record
////                $record->update($data);
////            })
////            ->successNotificationTitle('Record updated successfully')
////            ->mountUsing(function ($form, $record) {
////                // This mounts the existing data to the form when the modal opens
////                $form->fill($record->toArray());
////            }),
////    ];
//    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
