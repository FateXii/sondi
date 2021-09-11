<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SectionalsController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserProfileController;
use App\Http\Resources\UserProfileResource;
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
  return new UserProfileResource($request->user()->profile);
});

Route::apiResource('profiles', UserProfileController::class)->middleware('auth:sanctum');

Route::apiResource(
  'properties',
  PropertyController::class
);

Route::apiResource(
  'sectionals',
  SectionalsController::class
);

Route::apiResource(
  'address',
  AddressController::class
);
