<?php

declare(strict_types=1);

use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\ReportController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantSettingController;
use App\Models\Invoice;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
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
    Route::get('testview', function(){
        return view('app.test');
    })->name('testview');
    // only for superadmin role user
    Route::middleware('auth', 'role:superadmin')->group(function () {
        Route::get('/users',[AppController::class,'index']);
        Route::resource('users',UserController::class);
    });

    // for login user
    Route::middleware('auth')->group(function () {

        Route::get('/',[ReportController::class,'index'])->name('app.index');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::get('/profile', function(){dd('hi');})->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // for inventory product
        Route::resource('products',ProductController::class);
        Route::get('products/deleted/index',[ProductController::class,'deleted' ] )->name('products.deleted');
        // Route::post('products/restore',[ProductController::class,'restore' ] )->name('products.restore');
        Route::get('products/{product}/restore',[ProductController::class,'restore' ] )->name('products.restore')->withTrashed();;


        // invoice
        Route::resource('invoices',InvoiceController::class);
        Route::get('invoices/deleted/index',[InvoiceController::class,'deleted' ] )->name('invoices.deleted');
        Route::get('invoices/{invoiceId}/print', [InvoiceController::class,'print'])->name('invoices.print');
        // Route::get('invoices/create', 'create')->name('admin.invoices.create');





        // ------------for api route but not set yet----------------//
        Route::get('api/customer/getCustomerById', [CustomerController::class,'ajaxGetCustomerById']);


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

        // get zones list
        Route::get('api/invoices/getZones', [InvoiceController::class,'ajaxSearchProvinces']);
        Route::get('api/invoices/getWardsByZone', [InvoiceController::class,'ajaxGetWardsByZone']);

        Route::get('api/report/revenue/monthly', [ReportController::class,'ajaxReportByYear']);
        Route::get('api/report/revenue/daily-in-month', [ReportController::class,'ajaxReportRevenueByMonth']);
        Route::get('api/report/revenue/daily-in-week', [ReportController::class,'ajaxReportRevenueByWeek']);

        // Route::post('admin/ajax-restore', 'ajaxRestore')->name('admin.invoices.ajaxrestore');
        // Route::post('admin/ajax-delete-permanently', 'ajaxDestroyPermanently');

        Route::get('in/{id}', [InvoiceController::class,'printMultipleInvoices']);

        // Route::get('/in/{id}', function(Request $request){
        //     // $invoice = Invoice::findOrFail(11);
        //     // $customer = $invoice->customer;
        //     // $invoiceDetails = $invoice->invoiceDetails;
        //     dd($request->all());
        //     $invoices = Invoice::latest()->with('products','customer','invoiceDetails')->get();

        //     $pdf = LaravelMpdf::loadView('app.invoice.print_multiple_invoices', compact('invoices'));
        //     return $pdf->stream('invoices.pdf');
        // });
        //---------------------------- seetting ----------------------------//
        // Route để hiển thị form chỉnh sửa tùy chỉnh
        Route::get('/settings/display/edit', [TenantSettingController::class, 'editDisplaySettings'])->name('tenant.settings.display.edit');
        // Route để xử lý yêu cầu cập nhật tùy chỉnh
        Route::post('/settings/display/update', [TenantSettingController::class, 'updateDisplaySettings'])->name('tenant.settings.display.update');

        // ternant information
        Route::get('/setting/info/edit', [TenantSettingController::class, 'editInfo'])->name('tenant.settings.info.edit');
        Route::post('/settings/info/update', [TenantSettingController::class, 'updateInfo'])->name('tenant.settings.info.update');

        //----------------------------end seetting ----------------------------//













        // Route::get('admin/invoices/ajax-filter-deleted-ivoices','ajaxFilterDeletedInvoicesByDateRange');
        // Route::delete('admin/invoices/ajax-delete', 'ajaxDelete');
        // Route::post('admin/invoices/ajax-create-product', 'ajaxCreateProduct')->name('admin.invoices.ajaxCreateProduct');


        // end------------ for api route but not set yet----------------//






    });

    require __DIR__.'/tenant-auth.php';
});
