<?php

declare(strict_types=1);

use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {



    Route::get('create-permission', [PermissionController::class,'createTest']);


    // make this temperary, should delete this route


    // only for superadmin role user
    Route::middleware('auth', 'role:superadmin')->group(function () {
        Route::get('/users',[AppController::class,'index']);
        Route::resource('users',UserController::class);
    });

    // for login user
    Route::middleware('auth')->group(function () {

        // Route::get('/',[AppController::class,'index'])->name('app.index');
        Route::get('/',function(){
            return "index";
        })->name('app.index');
        // Route::get('/dashboard', function () {
        //     // return view('app.dashboard');
        //     return redirect()->route('app.index');
        // })->name('app.dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::get('/profile', function(){dd('hi');})->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // for inventory product
        Route::resource('products',ProductController::class);
        // invoice
        Route::resource('invoices',InvoiceController::class);
        Route::get('invoices/deleted/index',[InvoiceController::class,'deleted' ] )->name('invoices.deleted');
        Route::get('invoices/{invoiceId}/print', [InvoiceController::class,'print'])->name('invoices.print');
        // Route::get('invoices/create', 'create')->name('admin.invoices.create');



        // ------------for api route but not set yet----------------//
        Route::get('api/invoices/filter-invoices',[InvoiceController::class,'ajaxFilterInvoicesByDateRange' ] );
        Route::post('api/invoices/search-product', [InvoiceController::class,'ajaxSearchProduct']);
        Route::post('api/invoices/search-customer', [InvoiceController::class,'ajaxSearchCustomer']);
        Route::post('api/invoices/create-customer', [InvoiceController::class,'ajaxCreateCustomer']);
        Route::post('api/invoices/update-customer', [InvoiceController::class,'ajaxUpdateCustomer']);

        Route::post('api/invoices/create-product', [InvoiceController::class,'ajaxCreateProduct'])->name('invoices.ajaxCreateProduct');
        Route::delete('api/invoices/destroy', [InvoiceController::class,'ajaxDelete']);

        Route::get('api/invoices/filter-deleted-ivoices',[InvoiceController::class,'ajaxFilterDeletedInvoicesByDateRange']);
        Route::post('api/invoices/restore', [InvoiceController::class,'ajaxRestore']);
        Route::post('api/invoices/delete-permanently', [InvoiceController::class,'ajaxDestroyPermanently']);
        // Route::post('admin/ajax-restore', 'ajaxRestore')->name('admin.invoices.ajaxrestore');
        // Route::post('admin/ajax-delete-permanently', 'ajaxDestroyPermanently');










        // Route::get('admin/invoices/ajax-filter-deleted-ivoices','ajaxFilterDeletedInvoicesByDateRange');
        // Route::delete('admin/invoices/ajax-delete', 'ajaxDelete');
        // Route::post('admin/invoices/ajax-create-product', 'ajaxCreateProduct')->name('admin.invoices.ajaxCreateProduct');


        // end------------ for api route but not set yet----------------//






    });

    require __DIR__.'/tenant-auth.php';
});
