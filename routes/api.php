<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\FullPropertyController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SectionalsController;
use App\Http\Controllers\SectionalUnitController;
use App\Http\Controllers\StandAloneController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserProfileController;
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
Route::post('/sanctum/token', TokenController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::apiResource('profiles', UserProfileController::class)->middleware('auth:sanctum');

Route::apiResource(
  'properties',
  PropertyController::class
);

Route::post('/create_property', [FullPropertyController::class, 'create']);

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
