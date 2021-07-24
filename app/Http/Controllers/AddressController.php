<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Address::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $address = new Address;
    $address->street        = $request->street;
    $address->city          = $request->city;
    $address->province      = $request->province;
    $address->postal_code   = $request->postal_code;
    $address->is_sectional  = $request->is_sectional;
    $address->section_name  = $request->section_name;
    $address->unit          = $request->unit;
    $address->type          = $request->type;

    $address->save();
    return $address;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Address  $address
   * @return \Illuminate\Http\Response
   */
  public function show(Address $address)
  {
    return $address;
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Address  $address
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Address $address)
  {
    if (!$address) {
      return new Response([
        'error' => 'address not found',
      ], 404);
    }

    $fields = [
      'street',
      'suburb',
      'city',
      'province',
      'postal_code',
      'is_sectional',
      'section_name',
      'unit',
      'type'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $address[$field] = $request[$field];
      }
    }

    $address->save();

    return new Response([
      'message' => 'updated address',
      'address' =>  $address,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Address  $address
   * @return \Illuminate\Http\Response
   */
  public function destroy(Address $address)
  {
    $address->delete();
  }
}
