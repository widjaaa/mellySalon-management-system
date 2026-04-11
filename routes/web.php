<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;

Route::get('/login', function () {
    return view('auth.logi');
})->name('login');

Route::get('/', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::put('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

Route::post('/members', [MemberController::class, 'store']);
Route::post('/transactions', [TransactionController::class, 'store']);
