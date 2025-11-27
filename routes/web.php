<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ToolAdminController;

Route::get('/', function () {
    return view('home');
});

Route::get('/tools', [ToolController::class, 'index'])->name('catalog');
Route::get('/tools/{id}', [ToolController::class, 'product'])->name('product');

Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.home');
    })->name('admin.dashboard');
    Route::get('/tools', [ToolAdminController::class, 'index'])
        ->name('admin.tools');
    Route::get('/tools/create', [ToolAdminController::class, 'create'])->name('admin.tools.create');
    Route::get('/tools/{id}/edit', [ToolAdminController::class, 'edit'])->name('admin.tools.edit');
    Route::put('/tools/{id}', [ToolAdminController::class, 'update'])->name('admin.tools.update');
    Route::delete('/tools/{id}', [ToolAdminController::class, 'destroy'])->name('admin.tools.destroy');
});
