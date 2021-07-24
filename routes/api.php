<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\SalesController;
use App\Models\Address;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource(
  'properties',
  PropertyController::class
);

Route::apiResource(
  'properties.photos',
  PhotoController::class
);

Route::apiResource(
  'sales',
  SalesController::class
);

Route::apiResource(
  'addresses',
  Address::class
);

Route::apiResource(
  'rentals',
  RentalsController::class
);
