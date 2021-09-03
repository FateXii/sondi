<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Image::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $image = new Image;
    $image->path = $request->file('image')->store('images', 'public');
    $image->save();

    return $image;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Image  $image
   * @return \Illuminate\Http\Response
   */
  public function show(Image $image)
  {
    return $image;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Image  $image
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Image $image)
  {
    $request->validate([
      'image' => 'sometimes|required|file'
    ]);
    if (!$image) {
      return new Response([
        'error' => 'photo not found',
      ], 404);
    }
    $image->path = $request->file('image')->store('images', 'storage');
    $image->save();

    return $image;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Image  $photo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Image $photo)
  {
    Storage::delete($photo->path);
    $photo->delete();
  }
}
