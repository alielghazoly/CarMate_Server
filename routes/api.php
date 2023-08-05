<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ModelController;
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

// ACCOUNT ROUTES

Route::post('users/login', [AuthController::class, 'login'])->name('login');
Route::post('users/updateFcmToken', [AuthController::class, 'updateFcmToken'])->middleware('auth:api');
Route::post('users/updateUserPhone', [AuthController::class, 'updateUserPhone'])->middleware('auth:api');

// BRAND ROUTES

Route::get('brands/getAllBrands', [BrandController::class, 'getAllBrands'])->middleware('auth:api');
Route::post('brands/create', [BrandController::class, 'store']);

// MODEL ROUTES

Route::get('models/getCarBrandModels', [ModelController::class, 'getCarBrandModels'])->middleware('auth:api');

// DEVICES ROUTES

Route::post('devices/create', [DeviceController::class, 'store'])->middleware('auth:api');

// CARS ROUTES

Route::post('cars/create', [CarController::class, 'store'])->middleware('auth:api');
Route::post('cars/get', [CarController::class, 'get'])->middleware('auth:api');
Route::post('cars/updateCarSim', [CarController::class, 'updateCarSim'])->middleware('auth:api');
Route::post('cars/sync', [CarController::class, 'sync'])->middleware('auth:api');

