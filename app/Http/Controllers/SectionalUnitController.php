<?php

namespace App\Http\Controllers;

use App\Models\Sectionals;
use App\Models\SectionalUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionalUnitController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Sectionals $sectional)
  {
    return $sectional->sectionalUnit;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $unit = new SectionalUnit;
    $unit->unit = $request->unit;
    $unit->sectionals_id = (int)$request->sectional;
    $unit->save();
    return $unit;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sectionals  $sectional
   * @return \Illuminate\Http\Response
   */
  public function show(SectionalUnit $unit)
  {
    return $unit;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int $unit_id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request,  int $unit_id)
  {
    $sectionalUnit = SectionalUnit::findOrFail($unit_id);
    if (!$sectionalUnit) {
      return new Response([
        'error' => 'Unit not found',
      ], 404);
    }

    $fields = [
      'type',
      'unit',
      'sectionals_id'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $sectionalUnit[$field] = $request[$field];
      }
    }
    $sectionalUnit->save();

    return new Response([
      'message' => 'updated unit',
      'unit' =>  $sectionalUnit,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sectionals  $sectional
   * @param  \App\Models\SectionalUnit  $sectionalUnit
   * @return \Illuminate\Http\Response
   */
  public function destroy(SectionalUnit $unit)
  {
    $unit->delete();
  }
}
