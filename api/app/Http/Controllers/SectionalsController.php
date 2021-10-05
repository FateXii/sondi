<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionalResource;
use App\Models\Address;
use App\Models\Sectionals;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionalsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return SectionalResource::collection(Sectionals::all());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|unique:sectionals,name',
      'type' => 'required|string',
      'street' => 'required|string',
      'city' => 'required|string',
      'province' => 'required|string',
      'postal_code' => 'required|string',

    ]);
    $sectional = new Sectionals();
    $sectional->name = $request['name'];
    $sectional->type = $request['type'];
    $sectional->save();

    Address::create([
      'street' => $request['street'],
      'city' => $request['city'],
      'province' => $request['province'],
      'postal_code' => $request['postal_code'],
      'sectionals_id' => $sectional->id,
    ]);

    return response()->json([], Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function show(Sectionals $sectional)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sectionals $sectional)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sectionals $sectional)
  {
    $deleted = $sectional;
    $sectional->delete();
    return $deleted;
  }
}
