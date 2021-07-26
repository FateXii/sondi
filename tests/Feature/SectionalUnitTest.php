<?php

namespace Tests\Feature;

use App\Models\Sectionals;
use App\Models\SectionalUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SectionalUnitTest extends TestCase
{
  use RefreshDatabase;
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_create()
  {
    $sectional = Sectionals::factory()->create();
    $sectional_id = $sectional->id;
    $unit = '21';
    $response = $this->post(
      '/api/sectionals/' . $sectional_id . '/unit/',
      [
        'unit' => $unit
      ]
    );

    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->has('id')
        ->where('sectionals_id', $sectional_id)
        ->where('unit', $unit)
        ->etc()
    );
    $response->assertStatus(201);
  }

  public function test_list()
  {
    $sectional_id = 77;
    $sectional = Sectionals::factory()->state([
      'id' => $sectional_id
    ])->create();
    $units = SectionalUnit::factory()
      ->for($sectional)
      ->count(5)
      ->create();
    $response = $this->getJson(
      '/api/sectionals/' . $sectional_id . '/unit/'
    );
    $response->assertStatus(200);
    $response->assertJson($units->jsonSerialize());
  }
  public function test_detail()
  {
    $sectional_id = 77;
    $sectional = Sectionals::factory()->state([
      'id' => $sectional_id
    ])->create();
    $unit = SectionalUnit::factory()
      ->for($sectional)
      ->create();
    $unit_id = $unit->id;
    $response = $this->getJson(
      '/api/unit/' . $unit_id
    );
    $response->assertStatus(200);
    $response->assertJson($unit->jsonSerialize());
  }

  public function test_delete()
  {
    $sectional_id = 77;
    $sectional = Sectionals::factory()->state([
      'id' => $sectional_id
    ])->create();
    $units = SectionalUnit::factory()
      ->for($sectional)
      ->count(5)
      ->create();

    $unit = $units->offsetGet(3);
    $response = $this->delete('/api/unit/' . $unit->id);
    $this->assertDeleted($unit);
    $response->assertStatus(200);
  }

  public function test_update()
  {
    $sectional_id = 77;
    $sectional = Sectionals::factory()->state([
      'id' => $sectional_id
    ])->create();
    $units = SectionalUnit::factory()
      ->for($sectional)
      ->count(5)
      ->create();

    $unit = $units->offsetGet(3);
    $unit_number = '21';
    $unit_id = $unit->id;
    $response = $this->put(
      '/api/unit/' . $unit_id,
      [
        'unit' => $unit_number,
        'sectionals_id' => $unit->sectionals_id,
      ]
    );
    $response->assertStatus(200);
    $this->assertDatabaseHas('sectional_units', [
      'id' => $unit->id,
      'unit' => $unit_number,
      'sectionals_id' => $sectional_id
    ]);

    $response->assertJson(
      fn (AssertableJson $json) =>
      $json
        ->where('message', 'updated unit')
        ->where('unit.id', $unit->id)
        ->where('unit.unit', $unit_number)
        ->etc()
    );
  }
}
