<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
// logout
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('category/{slug}', [App\Http\Controllers\HomeController::class, 'category'])->name('category');
Route::get('download/{image}', [App\Http\Controllers\HomeController::class, 'download'])->name('download');
Route::get('search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

Route::prefix('admin')->group(function () {
    Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.post');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

        Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home.index');

        Route::get('category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('category', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('category/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
        
        Route::get('image', [App\Http\Controllers\Admin\ImageController::class, 'index'])->name('admin.image.index');
        Route::get('image/create', [App\Http\Controllers\Admin\ImageController::class, 'create'])->name('admin.image.create');
        Route::post('image', [App\Http\Controllers\Admin\ImageController::class, 'store'])->name('admin.image.store');
        Route::get('image/edit/{id}', [App\Http\Controllers\Admin\ImageController::class, 'edit'])->name('admin.image.edit');
        Route::post('image/update/{id}', [App\Http\Controllers\Admin\ImageController::class, 'update'])->name('admin.image.update');
    });
});