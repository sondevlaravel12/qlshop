<?php

declare(strict_types=1);

use App\Http\Controllers\App\ProfileController;
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

    // Route::get('tenants/create', [TenantController::class,'create'])->name('tenants.create');
    // Route::post('tenants/store', [TenantController::class,'store'])->name('tenants.store');
    // Route::get('tenants/offf', [TenantController::class,'offTenant'])->name('tenants.off');
    // Route::get('tenants/{tenants}', [TenantController::class,'show'])->name('tenants.show');
    Route::resource('products',ProductController::class);

    // make this temperary, should delete this route
    Route::get('/dashboard', function () {
        // return view('app.dashboard');
        return redirect()->route('app.index');
    })->middleware(['auth'])->name('app.dashboard');



    Route::middleware('auth')->group(function () {
        Route::get('/',[AppController::class,'index'])->name('app.index');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::get('/profile', function(){dd('hi');})->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // tenant  CRUID
        // Route::get('tenants/all', [TenantController::class,'index'])->name('tenants.index');
        // Route::get('tenants/create', [TenantController::class,'create'])->name('tenants.create');
        // Route::post('tenants/store', [TenantController::class,'store'])->name('tenants.store');
        // Route::get('tenants/offf', [TenantController::class,'offTenant'])->name('tenants.off');
        // // Route::get('tenants/{tenants}', [TenantController::class,'show'])->name('tenants.show');
        // Route::get('tenants/{tenant}', [TenantController::class,'gotoTenant'])->name('gototenant');

    });

    require __DIR__.'/tenant-auth.php';
});
