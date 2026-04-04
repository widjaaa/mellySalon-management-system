<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::get('/', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::put('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
