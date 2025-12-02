<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ToolAdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('home');
});

// Public tools
Route::get('tools', [ToolController::class, 'index'])->name('catalog');
Route::get('tools/{id}', [ToolController::class, 'product'])->name('product');

// ADMIN AUTH
Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// ADMIN PROTECTED (tanpa bootstrap, tanpa auth.admin)
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', function () {
            return view('admin.home');
        })->name('dashboard');

        Route::prefix('kategori')->name('categories.')->group(function () {
            Route::get('create', function () {
                return view('admin.manage.form-category', ['mode' => 'create', 'header' => 'Tambah Kategori']);
            })->name('create');
        });

        Route::get('tools', [ToolAdminController::class, 'index'])->name('tools');
        Route::get('tools/create', [ToolAdminController::class, 'create'])->name('tools.create');
        Route::post('tools/create', [ToolAdminController::class, 'store'])->name('tools.store');
        Route::get('tools/{id}/edit', [ToolAdminController::class, 'edit'])->name('tools.edit');
        Route::put('tools/{id}', [ToolAdminController::class, 'update'])->name('tools.update');
        Route::delete('tools/{id}', [ToolAdminController::class, 'destroy'])->name('tools.destroy');
    });

// LOGOUT ADMIN
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
