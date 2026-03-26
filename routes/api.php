<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaladieRareController;
use Illuminate\Support\Facades\Route;

Route::apiResource('rare', MaladieRareController::class);
Route::post('/rare/generate', [MaladieRareController::class, 'generateDescription']);

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('refresh',[AuthController::class,'refresh']);
Route::post('logout',[AuthController::class,'logout']);

Route::middleware('auth:api')->group(function(){
    Route::get('profile', [AuthController::class, 'profile']);
});
Route::middleware(['auth:api','role:admin'])->group(function(){
    Route::delete('rare/{id}', [MaladieRareController::class, 'destroy']);
});