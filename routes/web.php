<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileExplorerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/explorer', [FileExplorerController::class, 'index'])->name('explorer.index');
Route::get('/explorer/navigate', [FileExplorerController::class, 'navigate'])->name('explorer.navigate');