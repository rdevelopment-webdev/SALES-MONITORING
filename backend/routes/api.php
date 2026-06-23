<?php
/*use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::prefix('admin')->group(function () {
   Route::resource('roles',RoleController::class);
});
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('pages', pageController::class);
});*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RolePagePermissionController;


Route::apiResource('role-page-permissions', RolePagePermissionController::class);
Route::apiResource('pages', PageController::class);
