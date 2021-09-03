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
      'video_url' => 'string',
      'stand_alones_id' => 'required_if:sectional_units_id,null|integer',
      'sectional_units_id' => 'required_if:stand_alones_id,null|integer',

    ]);
    $property = new Property;
    $property->bedrooms = $request->bedrooms;
    $property->cover_image = $request->file('image')->store('images', 'public');
    $property->bathrooms = $request->bathrooms;
    $property->garages = $request->garages;
    $property->description = $request->description;
    $property->video_url = $request->video_url;
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
      'video_url' => 'sometimes|required|string',
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
      'description',
      'url'
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
    Storage::delete($property->cover_image);
    $images = PropertyImage::all()->where('property_id', $property->id);
    foreach ($images as $image) {
      Storage::delete($property->cover_image);
      $currentImage = Image::all()->firstWhere('image_id', $image->image_id);
      Storage::delete($currentImage->path);
    }
    if ($property->sales()) {

      $property->sales()->delete();
    } else {
      $property->rentals()->delete();
    }
    if ($property->sectionalUnit()) {
      $property->sectionalUnit()->delete();
    } else {
      $property->standAlone()->address()->delete();
      $property->standAlone()->delete();
    }
    $property->$property->delete();
  }
}
