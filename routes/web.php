<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('admin:admin')->group(function(){
    Route::get('admin/login',[AdminController::class, 'loginForm']);
    Route::post('admin/login',[AdminController::class, 'store'])->name('admin.login');
});


Route::middleware(['auth:sanctum,admin',config('jetstream.auth_session'),'verified'
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');

    //Admin All Route

    Route::get('/admin/profile',[AdminProfileController::class, 'index'])->name('admin.profile');
    Route::get('/admin/profile/edit',[AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/admin/profile/store',[AdminProfileController::class, 'store'])->name('admin.profile.store');
    Route::get('/admin/logout',[AdminController::class, 'destroy'])->name('admin.logout');

    Route::get('/admin/change/password',[AdminProfileController::class, 'changePassword'])->name('admin.change.password');
    Route::post('/update/change/password',[AdminProfileController::class, 'change'])->name('update.change.password');

});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::prefix('category')->group(function(){
    Route::get('/view', [ProductCategoryController::class, 'view'])->name('all.category');
    Route::get('/add/category', [ProductCategoryController::class, 'add'])->name('add.category');
    Route::post('/store', [ProductCategoryController::class, 'store'])->name('category.store');
    Route::get('/edit/{id}', [ProductCategoryController::class, 'edit'])->name('category.edit');
    Route::post('/update', [ProductCategoryController::class, 'update'])->name('category.update');
    Route::get('/delete/{id}', [ProductCategoryController::class, 'delete'])->name('category.delete');
});

Route::prefix('product')->group(function(){
    //Route::get('/view', [ProductController::class, 'view'])->name('all.category');
    Route::get('/add', [ProductController::class, 'add'])->name('add.product');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('/manage', [ProductController::class, 'manage'])->name('manage.product');
    Route::post('/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('/update/product/image', [ProductController::class, 'updateGallery'])->name('update.product.image');
    Route::post('/update/product/main/image', [ProductController::class, 'updateImage'])->name('update.product.main.image');
    Route::get('/gallery/delete/{id}', [ProductController::class, 'deleteGallery'])->name('product.gallery.delete');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
});
