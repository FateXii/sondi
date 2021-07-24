<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PhotoController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Property $property)
  {
    return $property->photos;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $photo = new Photo;
    $photo->property_id = $request->property;
    $photo->cover_photo = $request->cover_photo;
    $photo->image_path = $request->file('image')
      ->store('images', 'public');

    $photo->save();

    return $photo;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Photo  $photo
   * @return \Illuminate\Http\Response
   */
  public function show(Property $property, Photo $photo)
  {
    return $property->photos()->where('id', $photo->id)->first();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Photo  $photo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Photo $photo)
  {
    //   $request->validate([
    //     'cover_photo' => 'sometimes|required'
    //   ]);
    //   if (!$photo) {
    //     return new Response([
    //       'error' => 'photo not found',
    //     ], 404);
    //   }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Photo  $photo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Photo $photo)
  {
    $photo->delete();
  }
}
