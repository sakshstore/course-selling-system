<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/student', [ StudentController::class, 'store']);
    Route::post('/student/{student}/enroll', [StudentController::class, 'enroll']);
 });

