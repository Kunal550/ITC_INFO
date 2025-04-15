<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::apiResource('students', StudentController::class);

Route::match(['GET', 'POST'],'students', [StudentController::class, 'index']); 
Route::match(['GET', 'POST'],'students/{id}', [StudentController::class, 'show']); 
Route::post('students', [StudentController::class, 'store']); 
Route::put('students/{id}', [StudentController::class, 'update']);
Route::delete('students/{id}', [StudentController::class, 'destroy']);