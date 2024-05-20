<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

// can not set '/' link???
Route::get('/home', function () {
    return view('welcome');
})->name('center.home');
Route::get('/dashboardcenter', function () {
    return view('dashboard');
})->middleware(['centerAuth', 'verified'])->name('center.dashboard');


Route::middleware('centerAuth')->group(function () {
    // Route::get('/all', [TenantController::class,'index'])->name('tenants.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // tenant  CRUID
    Route::get('tenants/all', [TenantController::class,'index'])->name('tenants.index');
    Route::get('tenants/create', [TenantController::class,'create'])->name('tenants.create');
    Route::post('tenants/store', [TenantController::class,'store'])->name('tenants.store');
    Route::get('tenants/offf', [TenantController::class,'offTenant'])->name('tenants.off');
    // Route::get('tenants/{tenants}', [TenantController::class,'show'])->name('tenants.show');
    Route::get('tenants/{tenant}', [TenantController::class,'gotoTenant'])->name('gototenant');

});


require __DIR__.'/auth.php';
