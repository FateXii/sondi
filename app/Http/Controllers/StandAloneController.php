<?php

namespace App\Http\Controllers;

use App\Models\StandAlone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\PrettyPrinter\Standard;

class StandAloneController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return StandAlone::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $standAlone = new StandAlone;
    $standAlone->addresses_id = $request->addresses_id;
    $standAlone->save();
    return $standAlone;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\StandAlone  $standAlone
   * @return \Illuminate\Http\Response
   */
  public function show(StandAlone $standAlone)
  {
    if (!$standAlone) {
      return new Response([
        'message' => 'property not found'
      ], 404);
    }
    return $standAlone;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\StandAlone  $standAlone
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, StandAlone $standAlone)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\StandAlone  $standAlone
   * @return \Illuminate\Http\Response
   */
  public function destroy(StandAlone $standAlone)
  {
    $standAlone->delete();
  }
}
