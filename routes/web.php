<?php

use App\Http\Controllers\FileController;
use App\Livewire\PublishedResearch;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});


    Route::get("files/download/{research}", [FileController::class, "download"])->name("files.download");
    Route::get('/home', PublishedResearch::class);
Route::get('/about', function () {
    return view('about');
});//    Route::get('/home/{record}', PublishedResearch::class);

