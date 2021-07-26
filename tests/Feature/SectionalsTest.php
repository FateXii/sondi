<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Sectionals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SectionalsTest extends TestCase
{
  use RefreshDatabase;

  public function test_create()
  {
    $address = Address::factory()->create();

    $address_id = $address->id;

    $section_name = 'Some Section';
    $section_type = 'apartment';

    $response = $this->postJson(
      '/api/sectionals',
      [
        'addresses_id' => $address_id,
        'name' => $section_name,
        'type' => $section_type
      ]
    );

    $response->assertStatus(201);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json
        ->where('name', $section_name)
        ->where('type', $section_type)
        ->where('addresses_id', $address_id)
        ->etc()
    );
  }

  public function test_list()
  {
    $sectionals = Sectionals::factory()
      ->count(5)
      ->create();
    $section = $sectionals->offsetGet(0);
    $response = $this->get('/api/sectionals');
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->has(5)
        ->first(
          fn (AssertableJson $json) =>
          $json->where('id', $section->id)
            ->where('name', $section->name)
            ->where('address', $section->address)
            ->etc()
        )
    );
  }

  public function test_detail()
  {
    $sectionals = Sectionals::factory()
      ->count(5)
      ->create();
    $section = $sectionals->offsetGet(2);
    $response = $this->get('/api/sectionals/' . $section->id);
    $response->assertStatus(200);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', $section->id)
        ->where('name', $section->name)
        ->where('address', $section->address)
        ->etc()
    );
  }

  public function test_update()
  {
    $sectionals = Sectionals::factory()
      ->count(5)
      ->create();
    $section = $sectionals->offsetGet(2);
    $updated_name = 'updated name';

    $response = $this->put('/api/sectionals/' . $section->id, [
      'name' => $updated_name,
    ]);

    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('message', 'updated sectional')
        ->has(
          'sectional',
          null,
          fn (AssertableJson $json) =>
          $json->where('id', $section->id)
            ->where('name', $updated_name)
            ->etc()
        )
        ->etc()
    );
    $response->assertStatus(200);
  }

  public function test_delete()
  {
    $this->assertDatabaseCount('sectionals', 0);
    $sectionals = Sectionals::factory()
      ->count(5)
      ->create();
    $section = $sectionals->offsetGet(2);
    $this->assertDatabaseCount('sectionals', 5);

    $response = $this->delete('/api/sectionals/' . $section->id);
    $this->assertDeleted($section);
    $this->assertDatabaseCount('sectionals', 4);
    $response->assertStatus(200);
    $this->assertDatabaseMissing('sectionals', $section->jsonSerialize());
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', $section->id)
        ->where('name', $section->name)
        ->etc()
    );
  }
}
