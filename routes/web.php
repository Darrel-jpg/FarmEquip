<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;

Route::get('/', function () {
    return view('home');
});

Route::get('/tools', [ToolController::class, 'index'])->name('catalog');
Route::get('/tools/{id}', [ToolController::class, 'product'])->name('product');