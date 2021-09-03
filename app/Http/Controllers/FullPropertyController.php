<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Rentals;
use App\Models\Sales;
use App\Models\Sectionals;
use App\Models\SectionalUnit;
use App\Models\StandAlone;
use Illuminate\Http\Request;

class FullPropertyController extends Controller
{
  /**
   * Create a full property
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $request->validate([
      'isSectional' => 'required|boolean',
      'sectionalType' => 'required_if:isSectional,True|string',
      'name' => 'required_if:isSectional,True|string',
      'unit' => 'required_if:isSectional,True|string|nullable',

      'bedrooms' => 'required|integer',
      'bathrooms' => 'required|integer',
      'garages' => 'required|integer',

      'description' => 'required|string',
      'sale' => 'required|boolean',
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
    $address = $this->create_address($address_data);

    $property_data = [
      'bedrooms' => $request->bedrooms,
      'bathrooms' => $request->bathrooms,
      'garages' => $request->garages,
      'description' => $request->description,
      'video_url' => $request->video_url,
      'title' => $request->title,
      'cover_image' => $cover_image,
      'address' => $address->id,
    ];
    if ($request->isSectional) {
      $sectional_property_data = [
        'name' => $request->name,
        'type' => $request->type,
        'street_address' => $address->street,
      ];
      $unit = $this->create_sectional_unit(
        $sectional_property_data,
        $request->unit
      );
      $property_data['sectional_units_id'] = $unit->id;
    } else {
      $standAloneData = [
        'addresses_id' => $address->id,
      ];
      $standAlone = $this->create_stand_alone($standAloneData);
      $property_data['stand_alones_id'] = $standAlone->id;
    }
    $property = $this->create_property($property_data, $request->isSectional);

    if ($request->sale) {
      $this->create_sale([
        'property_id' => $property->id,
        'price' => $request->price,
      ]);
    } else {
      $this->create_rental([
        'property_id' => $property->id,
        'price' => $request->price,
      ]);
    }

    $this->create_property_images(
      $property->id,
      $request
    );
    return $property;
  }

  private function create_rental($rental_data)
  {
    $rental = new Rentals;
    $rental->property_id = $rental_data['property_id'];
    $rental->price = $rental_data['price'];
    $rental->save();

    return $rental;
  }
  private function create_sale($sale_data)
  {
    $sale = new Sales;
    $sale->property_id = $sale_data['property_id'];
    $sale->price = $sale_data['price'];

    $sale->save();
    return $sale;
  }
  private function create_property_images($property_id, $request)
  {
    foreach ($request->file('images') as $file) {
      $propertyImage = new PropertyImage;
      $propertyImage->property_id = $property_id;

      $image = new Image;
      $image->path = $file->store('images', 'public');
      $image->save();

      $propertyImage->image_id = $image->id;
      $propertyImage->save();
    }
  }
  private function create_stand_alone($standAloneData)
  {
    $standAlone = new StandAlone;
    $standAlone->addresses_id = $standAloneData['addresses_id'];
    $standAlone->save();
    return $standAlone;
  }
  private function create_address($address_data)
  {
    $address = new Address;
    $address->street        = $address_data['street'];
    $address->city          = $address_data['city'];
    $address->province      = $address_data['province'];
    $address->postal_code   = $address_data['postal_code'];

    $address->save();
    return $address;
  }
  private function create_sectional_unit($sectional_property_data, $unit_string)
  {
    $sectional = $this->create_sectional_property($sectional_property_data);
    $unit = new SectionalUnit;
    $unit->unit = $unit_string;
    $unit->sectionals_id = $sectional->id;
    $unit->save();

    return $unit;
  }
  private function create_sectional_property($sectional_property_data)
  {
    $sectional = new Sectionals;
    $sectional->name = $sectional_property_data['name'];
    $sectional->type = $sectional_property_data['type'];
    $sectional->street_address = $sectional_property_data['street_address'];

    $sectional->save();

    return $sectional;
  }
  private function create_property($property_data, $isSectional)
  {
    $property = new Property;
    $property->bedrooms = $property_data['bedrooms'];
    $property->bathrooms = $property_data['bathrooms'];
    $property->garages = $property_data['garages'];
    $property->description = $property_data['description'];
    $property->video_url = $property_data['video_url'];
    $property->title = $property_data['title'];
    $property->addresses_id = $property_data['address'];

    if ($isSectional) {
      $property->sectional_units_id = $property_data['sectional_units_id'];
    } else {
      $property->stand_alones_id = $property_data['stand_alones_id'];
    }
    $property->cover_image = $property_data['cover_image'];
    $property->save();

    return $property;
  }
}
