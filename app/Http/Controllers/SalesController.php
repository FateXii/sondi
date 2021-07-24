<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $sales = Sales::all();
    return $sales->map(
      function (Sales $sale_prop, $key) {
        return [
          'id' => $sale_prop->id,
          'property' => $sale_prop->property,
          'price' => $sale_prop->price
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
    $sale = new Sales();
    $sale->property_id = $request->property;
    $sale->price = $request->price;

    $sale->save();

    return new Response(
      [
        'id' => $sale->id,
        'property' => $sale->property,
        'price' => $sale->price
      ],
      Response::HTTP_CREATED
    );
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sales  $sales
   * @return \Illuminate\Http\Response
   */
  public function show(Sales $sale)
  {
    if (!$sale) {
      return new Response([
        'error' => 'not found',
      ], 404);
    }
    return [
      'id' => $sale->id,
      'property' => $sale->property,
      'price' => $sale->price
    ];
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Sales  $sales
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sales $sale)
  {
    if (!$sale) {
      return new Response([
        'error' => 'property not found',
      ], 404);
    }

    $fields = [
      'price'
    ];
    foreach ($fields as $field) {
      if ($request->filled($field)) {
        $sale[$field] = $request[$field];
      }
    }

    $sale->save();

    return new Response([
      'message' => 'updated property',
      'property' =>  $sale,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sales  $sales
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sales $sales)
  {
    $sales->delete();
  }
}
