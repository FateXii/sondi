<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
  /**
   * Display a listing of the property.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Property::all();
  }

  /**
   * Store a newly created property in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'bedrooms' => 'required|integer',
      'bathrooms' => 'required|integer',
      'garages' => 'required|integer',
      'description' => 'required|string',
      'stand_alones_id' => 'required_if:sectional_units_id,null|integer',
      'sectional_units_id' => 'required_if:stand_alones_id,null|integer',

    ]);
    $property = new Property;
    $property->bedrooms = $request->bedrooms;
    $property->bathrooms = $request->bathrooms;
    $property->garages = $request->garages;
    $property->description = $request->description;
    $property->sectional_units_id = $request->sectional_units_id;
    $property->stand_alones_id = $request->stand_alones_id;

    $property->save();

    return $property;
  }

  /**
   * Display the specified property.
   *
   * @param  \App\Models\Property  $property
   * @return \Illuminate\Http\Response
   */
  public function show(Property $property)
  {
    if (!$property) {
      return new Response([
        'message' => 'property not found',
      ], 404);
    }
    return $property;
  }

  /**
   * Update the specified property in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Property  $property
   * @return \Illuminate\Http\Response
   */
  public function update(
    Request $request,
    Property $property
  ) {
    $request->validate([
      'bedrooms' => 'sometimes|required|integer',
      'bathrooms' => 'sometimes|required|integer',
      'garages' => 'sometimes|required|integer',
      'description' => 'sometimes|require|string'
    ]);
    if (!$property) {
      return new Response([
        'error' => 'property not found',
      ], 404);
    }

    $fields = [
      'bedrooms',
      'bathrooms',
      'garages',
      'description'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $property[$field] = $request[$field];
      }
    }

    $property->save();

    return $property;
  }

  /**
   * Remove the specified property from storage.
   *
   * @param  \App\Models\Property  $property
   * @return \Illuminate\Http\Response
   */
  public function destroy(Property $property)
  {
    $property->delete();
  }
}
