<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\API\EmpleadoController;
//libreria
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('producto', ProductoController::class);
Route::apiResource('empleados', EmpleadoController::class);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route:apiResource('productos',ProductoController::class)->names('api.productos');
    
});