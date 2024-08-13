<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('register', [App\Http\Controllers\RegisterController::class, 'index'])->name('register');
Route::post('register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.post');

Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
// logout
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('category/{slug}', [App\Http\Controllers\HomeController::class, 'category'])->name('category');
Route::get('download/{image}', [App\Http\Controllers\HomeController::class, 'download'])->name('download');
Route::get('search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::post('like', [App\Http\Controllers\HomeController::class, 'like'])->name('like');
Route::get('favourite', [App\Http\Controllers\FavouriteController::class, 'index'])->name('favourite')->middleware('auth');
Route::post('upload', [App\Http\Controllers\HomeController::class, 'uploadImage'])->name('uploadImage');

Route::prefix('admin')->group(function () {
    Route::middleware([AdminMiddleware::class])->group(function () {
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