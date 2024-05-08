<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//    ->middleware('can:Dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/product', [ProductController::class, 'index'])->name('product.index')->middleware('can:View Product');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create')
    ->middleware('can:Add Product');
Route::post('/product', [ProductController::class, 'store'])->name('product.store')
    ->middleware('can:Add Product');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit')
    ->middleware('can:Edit Product');
Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update')
    ->middleware('can:Edit Product');
Route::delete('/product/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy')
    ->middleware('can:Delete Product');
Route::get('/product/import', [\App\Http\Controllers\Admin\ProductController::class, 'file'])->name('product.file');
Route::post('//product/import', [\App\Http\Controllers\Admin\ProductController::class, 'importFile'])->name('product.file');

Route::get('/user', [UserController::class, 'index'])->name('user.index')
    ->middleware('can:View User');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create')
    ->middleware('can:Add User');
Route::post('/user', [UserController::class, 'store'])->name('user.store')
    ->middleware('can:Add User');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit')
    ->middleware('can:Edit User');
Route::put('/user/{user}/update', [UserController::class, 'update'])->name('user.update')
    ->middleware('can:Edit User');
Route::delete('/user/{user}/destroy', [UserController::class, 'destroy'])->name('user.destroy')
    ->middleware('can:Delete User');
Route::get('/user/import', [\App\Http\Controllers\Admin\UserController::class, 'fileImport'])->name('user.fileImport');
Route::post('//user/import', [\App\Http\Controllers\Admin\UserController::class, 'importFile'])->name('user.file');
Route::get('//user/export', [\App\Http\Controllers\Admin\UserController::class, 'exportFile'])->name('user.fileExport');

Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index')
    ->
    middleware('can:View Permission')
;
Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create')
    ->middleware('can:Add Permission')
;
Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store')
    ->middleware('can:Add Permission');
Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit')
    ->middleware('can:Edit Permission')
;
Route::put('/permission/{permission}/update', [PermissionController::class, 'update'])
    ->name('permission.update')
    ->middleware('can:Edit Permission')
;
Route::delete('/permission/{permission}/destroy', [PermissionController::class, 'destroy'])
    ->name('permission.destroy')
    ->middleware('can:Delete Permission')
;

Route::get('/role', [RoleController::class, 'index'])->name('role.index')
    ->middleware('can:View Role')
;
Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')
    ->middleware('can:Add Role')
;
Route::post('/role', [RoleController::class, 'store'])->name('role.store')
    ->middleware('can:Add Role');
Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit')
    ->middleware('can:Edit Role')
;
Route::put('/role/{role}/update', [RoleController::class, 'update'])->name('role.update')
    ->middleware('can:Edit Role')
;
Route::delete('/role/{role}/destroy', [RoleController::class, 'destroy'])->name('role.destroy')
    ->middleware('can:Edit Role');

Route::get('sendEmail', function (){
    $data['email'][0]= 'truongnnhe170897@fpt.edu.vn';
    $data['email'][1] = 'truonghahaliv@gmail.com';
    dispatch(new \App\Jobs\SendMailLoginJob($data));
});
require __DIR__ . '/auth.php';
