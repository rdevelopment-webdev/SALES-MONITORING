<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\RolePagePermissionController;
use App\Http\Controllers\UserPagePermissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PerformancePlanController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SalesTaskController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProspectTechniqueController;
use App\Http\Controllers\SalesRepresentativeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WayOfCommunicationController;
use App\Http\Controllers\IndustryController;

Route::get('statuses', fn() => response()->json([
    'Emailed',
    'Called',
    'Prospect',
    'Rejected',
]));
Route::apiResource('industries', IndustryController::class);
Route::apiResource('performance_plans', PerformancePlanController::class);
Route::apiResource('ways_of_communication', WayOfCommunicationController::class)
    ->parameters(['ways_of_communication' => 'wayOfCommunication']);
Route::apiResource('services', ServiceController::class);
Route::apiResource('sales__representatives', SalesRepresentativeController::class)
    ->parameters(['sales__representatives' => 'salesRepresentative']);
Route::apiResource('prospect_techniques', ProspectTechniqueController::class);
Route::apiResource('roles', RoleController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users/archived', [UserController::class, 'archived']);
    Route::post('users/archive', [UserController::class, 'archiveSelected']);
    Route::post('users/{id}/restore', [UserController::class, 'restore']);
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);
    Route::apiResource('users', UserController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/audit_logs', [AuditLogController::class, 'index']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('role_page_permissions', RolePagePermissionController::class);
    Route::apiResource('user_page_permissions', UserPagePermissionController::class);
    Route::apiResource('pages', PageController::class);
});

Route::apiResource('salestasks', SalesTaskController::class);
Route::apiResource('archives', ArchiveController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('leads/archived', [LeadController::class, 'archived']);
    Route::post('leads/archive', [LeadController::class, 'archiveSelected']);
    Route::put('leads/{lead}/restore', [LeadController::class, 'restore']);
    Route::apiResource('leads', LeadController::class);
});

Route::get('archive-types', [ArchiveController::class, 'types']);
Route::get('archived/{type}', [ArchiveController::class, 'archived']);
Route::post('archive/{type}/{id}', [ArchiveController::class, 'archive']);
Route::post('unarchive/{type}/{id}', [ArchiveController::class, 'unarchive']);

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [LoginController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('me', [LoginController::class, 'me']);
    Route::post('change-password', [LoginController::class, 'changePassword']);
});
