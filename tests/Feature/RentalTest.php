<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Rentals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RentalTest extends TestCase
{
  use RefreshDatabase;

  public function test_create()
  {
    $property = Property::factory()
      ->state(['id' => 1])
      ->createOne();

    $rental_price = 451254.25;
    $response = $this->postJson('/api/rentals', [
      'price' => $rental_price,
      'property_id' => 1
    ]);

    $response->assertStatus(201);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json
        ->where('price', $rental_price)
        ->where('property', $property)
        ->etc()
    );
  }

  public function test_list()
  {
    $rental_properties = Rentals::factory()
      ->count(5)
      ->create();

    $rental = $rental_properties->offsetGet(0);

    $response = $this->getJson('/api/rentals');
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->has(5)
        ->first(
          fn (AssertableJson $json) =>
          $json->where('id', $rental->id)
            ->where('price', $rental->price)
            ->where('property', $rental->property)
            ->etc()
        )
    );
  }

  public function test_detail_view()
  {
    $this->assertDatabaseCount('rentals', 0);
    $rental_properties = Rentals::factory()
      ->count(5)
      ->create();

    $this->assertDatabaseCount('rentals', 5);
    $rental_id = $rental_properties->offsetGet(2)->id;
    $rental_price = $rental_properties->offsetGet(2)->price;
    $property = $rental_properties->offsetGet(2)->property;
    $response = $this->getJson(
      '/api/rentals/' . $rental_id
    );
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', $rental_id)
        ->where('price', $rental_price)
        ->where('property', $property)
        ->etc()
    );
  }
}
