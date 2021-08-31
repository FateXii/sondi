<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SectionalsController;
use App\Http\Controllers\SectionalUnitController;
use App\Http\Controllers\StandAloneController;
use App\Models\Address;
use App\Models\StandAlone;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware('auth:sanctum')->apiResource(
  'properties',
  PropertyController::class
);

Route::apiResource(
  'properties.images',
  PropertyImageController::class
)->shallow();

Route::apiResource(
  'sales',
  SalesController::class
);

Route::apiResource(
  'rentals',
  RentalsController::class
);

Route::apiResource(
  'sectionals',
  SectionalsController::class
);

Route::apiResource(
  'address',
  AddressController::class
);

Route::apiResource(
  'stand_alone',
  StandAloneController::class
);
Route::apiResource(
  'images',
  ImageController::class
);

Route::apiResource(
  'sectionals.unit',
  SectionalUnitController::class
)->shallow();
