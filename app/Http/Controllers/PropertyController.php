<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Address;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Sectionals;
use App\Models\SectionalUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
  /**
   * Display a listing of the property.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return PropertyResource::collection(
      Property::all()
    );
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
      'isSectional' => 'required|boolean',
      'sectionalType' => 'required_if:isSectional,True|string',
      'name' => 'required_if:isSectional,True|string',
      'unit' => 'required_if:isSectional,True|string|nullable',


      'description_title' => 'string',
      'description' => 'required|string',
      'is_rental' => 'required|boolean',
      'price' => 'required|integer',

      'street' => 'required|string',
      'province' => 'required|string',
      'postal_code' => 'required|string',
      'city' => 'required|string',

      'cover_image' => 'required|image',
      'title' => 'required|string',
      'video_url' => 'string',
      'images' => 'required|array'
    ]);
    $cover_image = $request->file('cover_image')->store('images', 'public');
    $address_data = [
      'street'        => $request->street,
      'city'          => $request->city,
      'province'      => $request->province,
      'postal_code'   => $request->postal_code,
    ];

    $property_data = [
      'bedrooms' => $request->bedrooms,
      'bathrooms' => $request->bathrooms,
      'garages' => $request->garages,
      'description' => $request->description,
      'video_url' => $request->video_url,
      'title' => $request->title,
      'cover_image' => $cover_image,
      'is_rental' => $request->is_rental,
    ];
    $property = $this->create_property($property_data, $request->isSectional);
    if ($request->is_sectional) {
      $sectional_property_data = [
        'name' => $request->name,
        'type' => $request->type,
      ];
      $sectional_id = $request->sectional_id;
      if (!$sectional_id) {
        $sectional = $this->create_sectional_property($sectional_property_data);
        $sectional_id = $sectional->id;
        $this->create_address($address_data, null, $sectional_id);
      }
      $this->create_sectional_unit(
        $request->unit,
        $sectional_id,
        $property->id
      );
    } else {
      $this->create_address($address_data, $property->id);
    }

    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $file) {
        $image = new Image;
        $image->property_id = $property->id;
        $image->path = $file->store('images', 'public');
        $image->save();
      }
    }
    return $property;
  }

  private function create_address($address_data, $property_id = null, $sectional_id = null)
  {
    $address = new Address();
    $address->street        = $address_data['street'];
    $address->city          = $address_data['city'];
    $address->province      = $address_data['province'];
    $address->postal_code   = $address_data['postal_code'];
    if ($property_id) {
      $address->property_id   = $property_id;
    } else {
      $address->sectionals_id = $sectional_id;
    }
    $address->$address->save();
    return $address;
  }
  private function create_sectional_unit($unit_string, $sectional_id, $property_id)
  {
    $unit = new SectionalUnit();
    $unit->unit = $unit_string;
    $unit->sectionals_id = $sectional_id;
    $unit->property_id = $property_id;
    $unit->save();

    return $unit;
  }
  private function create_sectional_property($sectional_property_data)
  {
    $sectional = new Sectionals();
    $sectional->name = $sectional_property_data['name'];
    $sectional->type = $sectional_property_data['type'];
    $sectional->save();

    return $sectional;
  }
  private function create_property($property_data)
  {
    $property = new Property();
    $property->description = $property_data['description_title'];
    $property->description = $property_data['description'];
    $property->video_url = $property_data['video_url'];
    $property->title = $property_data['title'];
    $property->addresses_id = $property_data['address'];
    $property->addresses_id = $property_data['features'];
    $property->addresses_id = $property_data['is_rental'];
    $property->addresses_id = $property_data['price'];
    $property->cover_image = $property_data['cover_image'];
    $property->save();

    return $property;
  }

  /**
   * Display the specified property.
   *
   * @param  integer  $property
   * @return \Illuminate\Http\Response
   */
  public function show(Property $property)
  {

    if (!$property) {
      return new Response([
        'message' => 'property not found',
      ], 404);
    }
    return new PropertyResource($property);
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
      'title' => 'sometimes|required|string',
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
      'video_url',
      'title',
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
  public function destroy($property)
  {
    $property = Property::where('id', $property)->first();
    Storage::delete($property->cover_image);
    $images = Image::all()->where('property_id', $property->id);
    foreach ($images as $image) {
      $currentImage = Image::all()->firstWhere('image_id', $image->image_id);
      Storage::delete($currentImage->path);
    }
    if ($property->sectionalUnit()) {
      $property->sectionalUnit()->delete();
    }
    $property->delete();
  }
}
