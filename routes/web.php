<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;

// "Login Form" Page
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// +++++++++++++++++++++++ Spatie Permission Routes +++++++++++++++++++++
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

// +++++++++++++ Stop "Register Form" +++++++++++++
// Auth::routes(['register'=>false]);

// "Home" route
Route::get('/home' , [HomeController::class , 'index'])->name('home');

// "sections" route
Route::resource('sections' , SectionsController::class);

// "products" route
Route::resource('products' , ProductsController::class);

// "index" route
Route::get('/{page}' , [AdminController::class , 'index']);
