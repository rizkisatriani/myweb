<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return ['test'];
});
Route::get('/keuangan', [KeuanganController::class, 'index'])->middleware('auth:sanctum');
Route::get('/summary', [KeuanganController::class, 'getSummary'])->middleware('auth:sanctum');
Route::middleware('api')->post('/keuangan', [KeuanganController::class, 'store']);
Route::middleware('api')->get('/keuangan/{id}', [KeuanganController::class, 'show']);
Route::middleware('api')->put('/keuangan/{id}', [KeuanganController::class, 'update']);
Route::middleware('api')->delete('/keuangan/{id}', [KeuanganController::class, 'destroy']);