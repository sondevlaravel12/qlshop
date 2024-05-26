<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
// 1) Web routes, are used when we want to return views.
// 2) Api routes, are used when we want to return json ( Api resource/collection ).
// By default, the web.php uses web middleware, whereas the api.php uses the api middleware.
//https://pineco.de/frequently-asked-questions-about-laravel-based-apis/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// for center api
Route::get('tenants/remove',[TenantController::class, 'ajaxRemove']);
Route::get('tenants/remove-permanently',[TenantController::class, 'ajaxRemovePermanently']);
Route::get('tenants/restore',[TenantController::class, 'ajaxRestore']);
Route::get('tenants/change-status',[TenantController::class, 'ajaxChangeStatus']);

// for tenant api
Route::middleware([
    // 'web',
    // 'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,

])->group(function () {
    // Route::get('/invoices/filter-invoices', [InvoiceController::class,'ajaxFilterInvoicesByDateRange' ] );
});
