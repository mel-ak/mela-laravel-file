<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileExplorerController;

Route::get('/', function () {
    return redirect()->route('explorer.index');
});

// File Explorer Routes
Route::prefix('explorer')->group(function () {
    // Main Explorer Route
    Route::get('/', [FileExplorerController::class, 'index'])->name('explorer.index');
    
    // Navigate Through Directories
    Route::get('/navigate', [FileExplorerController::class, 'navigate'])->name('explorer.navigate');
    
    // File Upload
    Route::post('/upload', [FileExplorerController::class, 'upload'])->name('explorer.upload');
    
    // File Preview
    Route::get('/preview', [FileExplorerController::class, 'preview'])->name('explorer.preview');
});
