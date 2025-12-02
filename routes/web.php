<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ToolAdminController;
use App\Http\Controllers\AdminAuthController;

// GUEST
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('tools', [ToolController::class, 'index'])->name('catalog');
Route::get('tools/{id}', [ToolController::class, 'product'])->name('product');

// ADMIN AUTH
Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// ADMIN
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('tools', [ToolAdminController::class, 'index'])->name('tools');
    Route::get('tools/create', [ToolAdminController::class, 'create'])->name('tools.create');
    Route::post('tools', [ToolAdminController::class, 'store'])->name('tools.store');
    Route::get('tools/{id}/edit', [ToolAdminController::class, 'edit'])->name('tools.edit');
    Route::put('tools/{id}', [ToolAdminController::class, 'update'])->name('tools.update');
    Route::delete('tools/{id}', [ToolAdminController::class, 'destroy'])->name('tools.destroy');
    Route::delete('categories/{id}', [ToolAdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
});