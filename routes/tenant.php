<?php

declare(strict_types=1);

use App\Http\Controllers\AppController;
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
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // })->name('hello');
    Route::get('/',[AppController::class,'index'])->name('app.index');
    // Route::get('/test', function(){
    //     return " this is the test page";
    // })->name('testroute');
    // Route::get('/', [TenantController::class,'index'])->name('tenants.index');
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    //     // return redirect()->route('testroute');
    // });
    // Route::get('tenants/create', [TenantController::class,'create'])->name('tenants.create');
    // Route::post('tenants/store', [TenantController::class,'store'])->name('tenants.store');
    // Route::get('tenants/offf', [TenantController::class,'offTenant'])->name('tenants.off');
    // Route::get('tenants/{tenants}', [TenantController::class,'show'])->name('tenants.show');
    Route::resource('products',ProductController::class);
});
