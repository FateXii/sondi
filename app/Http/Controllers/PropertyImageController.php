<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyImageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Property $property)
  {
    return $property->property_images->map(
      function (PropertyImage $property_image) {
        return Image::findOrFail($property_image->image_id);
      }
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $propertyImage = new PropertyImage;
    $propertyImage->property_id = $request->property;

    $image = new Image;
    $image->path = $request->file('image')->store('images', 'public');
    $image->save();

    $propertyImage->image_id = $image->id;
    $propertyImage->save();
    return new Response([
      'id' => $propertyImage['id'],
      'property_id' => $propertyImage['property_id'],
      'image' => $image->path,
    ], Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param  integer  $image_id
   * @return \Illuminate\Http\Response
   */
  public function show($image_id)
  {
    return Image::findOrFail($image_id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\PropertyImage  $propertyImage
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, PropertyImage $propertyImage)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\PropertyImage  $propertyImage
   * @return \Illuminate\Http\Response
   */
  public function destroy(Image $image)
  {
    $image->delete();
  }
}
