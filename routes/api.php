<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DeviceController;
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

Route::post('accounts/login', [AccountController::class, 'login']);
Route::post('accounts/update/{account}', [AccountController::class, 'update']);

// BRAND ROUTES

Route::get('brands/getAllBrands', [BrandController::class, 'getAllBrands']);
Route::post('brands/create', [BrandController::class, 'store']);

// MODEL ROUTES

Route::get('brands/getCarBrandModels', [BrandController::class, 'getCarBrandModels']);


Route::post('devices/create', [DeviceController::class, 'store']);
