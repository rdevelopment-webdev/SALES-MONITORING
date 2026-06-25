<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\RolePagePermissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PerformancePlanController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SalesTaskController;
use App\Http\Controllers\ArchiveController;


Route::apiResource('roles', RoleController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('audit_logs', AuditLogController::class);
Route::apiResource('role_page_permissions', RolePagePermissionController::class);
Route::apiResource('performance_plans', PerformancePlanController::class);
Route::apiResource('pages', PageController::class);
Route::apiResource('leads', LeadController::class);
Route::apiResource('salestasks', SalesTaskController::class);
Route::apiResource('archives', ArchiveController::class);