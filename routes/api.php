<?php

use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('tenants/remove',[TenantController::class, 'ajaxRemove']);
Route::get('tenants/remove-permanently',[TenantController::class, 'ajaxRemovePermanently']);
Route::get('tenants/restore',[TenantController::class, 'ajaxRestore']);
Route::get('tenants/change-status',[TenantController::class, 'ajaxChangeStatus']);
