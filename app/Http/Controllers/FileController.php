<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

class FileController extends Controller
{
    //
    public function downloadold(Request $request, Research $research)
    {
        $files = $research->files; // Assuming this gets the file details

        if ($files->isNotEmpty()) {
            // Assuming there's only one file, you might need to adjust if multiple files are associated
            $file = $files->first();

            $filePath = storage_path('app/public/' . $file->path); // Adjust the path as needed
            return response()->download($filePath, $file->original_name);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    public function download(Request $request, Research $research)
    {
        $files = $research->files; // Assuming this gets the file details

        if ($files->isNotEmpty()) {
            $zip = new ZipArchive();
            $zipFileName = "download.zip";
            $zipFilePath = public_path($zipFileName);

            if ($zip->open($zipFileName, ZipArchive::CREATE )) {
                foreach ($files as $file) {

                    $filePath = storage_path('app/public/' . $file->path);
                    $fileName = $file->original_name;
                    $zip->addFile($filePath, $fileName);
                }

                $zip->close();

                // Download the zip file
              return response()->download($zipFileName,$research->student->name.".zip")->deleteFileAfterSend();
                // Delete the zip file after sending\
            } else {
                return response()->json(['error' => 'Failed to create zip archive'], 500);
            }
        } else {
            return response()->json(['error' => 'Files not found'], 404);
        }
    }
}
