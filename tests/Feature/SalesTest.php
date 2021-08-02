<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Sales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SalesTest extends TestCase
{
  use RefreshDatabase;

  public function test_create()
  {
    $property = Property::factory()
      ->state(['id' => 1])
      ->createOne();

    $sale_price = 451254.25;
    $response = $this->postJson('/api/sales', [
      'price' => $sale_price,
      'property_id' => 1
    ]);

    $response->assertStatus(201);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json
        ->where('price', $sale_price)
        ->where('property', $property)
        ->etc()
    );
  }

  public function test_list()
  {
    $sale_properties = Sales::factory()
      ->count(5)
      ->create();

    $sale = $sale_properties->offsetGet(0);

    $response = $this->getJson('/api/sales');
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->has(5)
        ->first(
          fn (AssertableJson $json) =>
          $json->where('id', $sale->id)
            ->where('price', $sale->price)
            ->where('property', $sale->property)
            ->etc()
        )
    );
  }

  public function test_detail_view()
  {
    $this->assertDatabaseCount('sales', 0);
    $sale_properties = Sales::factory()
      ->count(5)
      ->create();

    $this->assertDatabaseCount('sales', 5);
    $sale_id = $sale_properties->offsetGet(2)->id;
    $sale_price = $sale_properties->offsetGet(2)->price;
    $property = $sale_properties->offsetGet(2)->property;
    $response = $this->getJson(
      '/api/sales/' . $sale_id
    );
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', $sale_id)
        ->where('price', $sale_price)
        ->where('property', $property)
        ->etc()
    );
  }
}
