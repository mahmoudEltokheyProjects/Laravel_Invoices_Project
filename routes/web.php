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

// "invoices" route
Route::resource('invoices' , InvoicesController::class);

// "add invoices" route
Route::get('invoices/create' , [InvoicesController::class , 'create']);

// "edit invoices" route
Route::get('/edit_invoice/{id}' , [InvoicesController::class , 'edit']);

// "edit invoices" route
Route::post('/archiveInvoice' , [InvoicesController::class , 'archiveInvoice'])->name('InvoiceArchiving');

// "invoice details" route
Route::get('/InvoicesDetails/{id}' , [InvoicesDetailsController::class , 'edit']);

// "attachments" route
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);

// "view attachment" route
Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class , 'open_file']);

// "download attachment" route
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class , 'download_file']);

// Change "invoice status" route
Route::get('/status_show/{id}', [InvoicesController::class ,'show'])->name('status_show');

// Update "invoice status" route
Route::post('/Status_Update/{id}',  [InvoicesController::class ,'Status_Update'])->name('Status_Update');

// "invoice Paid" route
Route::get('Invoice_Paid',[InvoicesController::class ,'Invoice_Paid']);

// "invoice partial paid " route
Route::get('partial_paid_invoice',[InvoicesController::class,'Invoice_Partial_Paid']);

// "invoice unpaid " route
Route::get('unpaid_invoice',[InvoicesController::class,'Invoice_Unpaid']);

// "delete attachment" route
Route::post('delete_file',[InvoicesDetailsController::class , 'destroy'])->name('delete_file');

// "Archive invoice" route
Route::resource('Archive', InvoiceAchiveController::class);
// "Print invoice" route
Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);
// "Export invoice Excel" route
Route::get('export_invoices', [InvoicesController::class, 'export']);
// +++++++++++++++++++++++++++++++ Invoice Report +++++++++++++++++++++++++++++++
// "Invoice Report" route
Route::get('invoices_report', [Invoices_Report::class, 'index']);
// "Invoice Search Report" route
Route::post('Search_invoices', [Invoices_Report::class, 'Search_invoices']);
// +++++++++++++++++++++++++++++++ Customer Report +++++++++++++++++++++++++++++++
// "Customer Report" route
Route::get('customers_report', [Customers_Report::class,'index'])->name("customers_report");
// "Search_customers Report" route
Route::post('Search_customers',[Customers_Report::class,'Search_customers']);

// "Ajax request" Route : To "Get" Products Related to "Section" You select from "add_invoices" page
Route::get('/section/{id}' , [InvoicesController::class , 'getproducts']);

// "sections" route
Route::resource('sections' , SectionsController::class);

// "products" route
Route::resource('products' , ProductsController::class);

// "index" route
Route::get('/{page}' , [AdminController::class , 'index']);

// +++++++++++++++++++++++++++++++ Notification Route +++++++++++++++++++++++++++++++
// 1- "Mark All Read" Route
Route::get('notifications/MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

