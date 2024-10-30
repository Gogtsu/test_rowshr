<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/count-roles/{project}', [ProjectController::class, 'fetchCountRoles']);
Route::get('/projects/filter/{role}', [ProjectController::class, 'listContainingRole']);
Route::delete('/projects/{project}/employees/{employee}', [ProjectController::class, 'removeEmployee']);
Route::post('/projects/{project}/change-role/{employee}', [ProjectController::class, 'changeRole']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees/{employee}/assign-project/{project}', [EmployeeController::class, 'assignProject']);
