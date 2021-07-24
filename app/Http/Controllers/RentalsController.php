<?php

namespace App\Http\Controllers;

use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RentalsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $rentals = Rentals::all();
    return $rentals->map(
      function (Rentals $rentals, $key) {
        return [
          'id' => $rentals->id,
          'property' => $rentals->property,
          'price' => $rentals->price
        ];
      }
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rental = new Rentals();
    $rental->property_id = $request->property;
    $rental->price = $request->price;

    $rental->save();

    return new Response(
      [
        'id' => $rental->id,
        'property' => $rental->property,
        'price' => $rental->price
      ],
      Response::HTTP_CREATED
    );
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Rentals  $rentals
   * @return \Illuminate\Http\Response
   */
  public function show(Rentals $rental)
  {
    if (!$rental) {
      return new Response([
        'error' => 'not found',
      ], 404);
    }
    return [
      'id' => $rental->id,
      'property' => $rental->property,
      'price' => $rental->price
    ];
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Rentals  $rentals
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Rentals $rental)
  {
    if (!$rental) {
      return new Response([
        'error' => 'property not found',
      ], 404);
    }

    $fields = [
      'price'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $rental[$field] = $request[$field];
      }
    }

    $rental->save();

    return new Response([
      'message' => 'updated property',
      'property' =>  $rental,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Rentals  $rentals
   * @return \Illuminate\Http\Response
   */
  public function destroy(Rentals $rentals)
  {
    $rentals->delete();
  }
}
