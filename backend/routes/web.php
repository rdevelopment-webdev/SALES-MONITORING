<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/sanctum/csrf-cookie', fn() => response()->json(['message' => 'CSRF cookie set']))
    ->middleware('web');
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::resource('roles',RoleController::class);
 });
