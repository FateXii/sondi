<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Address;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyAgent;
use App\Models\PropertyFeatures;
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
      (Property::orderByDesc('created_at')->paginate(10))
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
      'cover_image' => 'required|image',

      'agents' => 'array',

      'street' => 'required|string',
      'province' => 'required|string',
      'postal_code' => 'required|string',
      'city' => 'required|string',

      'is_sectional' => 'required|boolean',
      'unit' => 'required_if:is_sectional,True|string|nullable',
      'sectional_id' => 'required_if:is_sectional,true|string|nullable',

      'description_title' => 'string',
      'description' => 'required|string',

      'price' => 'required|integer',
      'is_rental' => 'required|boolean',

      'title' => 'required|string',

      'video_url' => 'string',
      'images' => 'required|array',
      'features' => 'required|json',
    ]);
    $cover_image = env('APP_URL') . '/' . 'storage' . '/' . $request->file('cover_image')->store('images', 'public');
    $address_data = [
      'street'        => $request->street,
      'city'          => $request->city,
      'province'      => $request->province,
      'postal_code'   => $request->postal_code,
    ];

    $property_data = [
      'title' => $request->title,
      'description' => $request->description,
      'description_title' => $request->description_title,
      'video_url' => $request->video_url,
      'cover_image' => $cover_image,
      'is_rental' => $request->is_rental,
      'price' => $request->price,
    ];
    $property = $this->create_property($property_data, $request->isSectional);
    $this->create_property_features($property->id, $request->features);
    if ($request->agents) {
      $this->create_property_agents($property->id, $request->agents);
    }
    if ($request->is_sectional != false) {
      $sectional_id = $request->sectional_id;
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
        $path = $file->store('images', 'public');
        $image->path = env('APP_URL') . '/' . 'storage' . '/' . $path;
        $image->save();
      }
    }
    return response()->json(['id' => $property->id], Response::HTTP_CREATED);
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
    $address->save();
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
  private function create_property_agents($property_id, $property_agents)
  {
    foreach ($property_agents as $agent) {
      PropertyAgent::create([
        'agent_id' => $agent,
        'property_id' => $property_id
      ]);
    }
  }
  private function create_property_features($property_id, $features_json)
  {
    $features = json_decode($features_json);
    foreach ($features as $feature) {
      PropertyFeatures::create([
        'feature_id' => $feature->id,
        'value' => $feature->value,
        'property_id' => $property_id
      ]);
    }
  }
  private function create_property($property_data)
  {
    $property = new Property();
    $property->description_title = $property_data['description_title'];
    $property->description = $property_data['description'];
    $property->video_url = $property_data['video_url'];
    $property->title = $property_data['title'];
    $property->cover_image = $property_data['cover_image'];
    $property->is_rental = $property_data['is_rental'];
    $property->price = $property_data['price'];
    $property->save();

    return $property;
  }

  /**
   * Display the specified property.
   *
   * @param  integer  $property
   * @return \Illuminate\Http\Response
   */
  public function show($property)
  {
    $property = Property::where('id', $property)->first();
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
      'video_url' => 'sometimes|required|string',
      'title' => 'sometimes|required|string',
      'description' => 'sometimes|require|string'
    ]);
    if (!$property) {
      return new Response([
        'error' => 'property not found',
      ], 404);
    }

    $fields = [
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
   * @param  int  $property_id
   * @return \Illuminate\Http\Response
   */
  public function destroy($property_id)
  {
    if (!Property::where('id', $property_id)->first()) {
      return new Response("Item does not exist", Response::HTTP_BAD_REQUEST);
    }
    /**
     * @var  \App\Models\Property  $property
     */
    $property = Property::where('id', $property_id)->first();
    $uri_components = explode('/', $property->cover_image);
    $image_path = array_pop($uri_components);
    Storage::delete($image_path);
    $images = Image::all()->where('property_id', $property->id);
    foreach ($images as $image) {
      $currentImage = Image::all()->firstWhere('image_id', $image->image_id);

      $uri_components = explode('/', $currentImage->path);
      $image_path = array_pop($uri_components);
      Storage::delete($image_path);
    }
    if ($property->sectional_unit() !== null) {
      $property->sectional_unit()->delete();
    }
    $property->delete();
    if (!Property::where('id', $property_id)->first()) {
      return new Response([
        'message' => 'property not found',
      ], Response::HTTP_NO_CONTENT);
    } else {
      return new Response([], Response::HTTP_BAD_REQUEST);
    }
  }
}
