<?php

namespace App\Http\Controllers;

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
    return Sectionals::all();
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
      'name' => 'required|string',
      'type' => 'required|string',
      'street_address' => 'required|string',
    ]);
    $sectional = new Sectionals;
    $sectional->name = $request->name;
    $sectional->type = $request->type;
    $sectional->street_address = $request->street_address;

    $sectional->save();

    return $sectional;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function show(Sectionals $sectional)
  {
    return [
      'id' => $sectional->id,
      'name' => $sectional->name,
      'type' => $sectional->type,
      'street_address' => $sectional->street_address,
    ];
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
    if (!$sectional) {
      return new Response([
        'error' => 'sectional not found',
      ], 404);
    }

    $fields = [
      'name', 'type', 'street_address'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $sectional[$field] = $request[$field];
      }
    }

    $sectional->save();

    return new Response([
      'message' => 'updated sectional',
      'sectional' =>  $sectional,
    ]);
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
