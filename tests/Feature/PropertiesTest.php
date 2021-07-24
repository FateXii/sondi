<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function GuzzleHttp\json_encode;

class PropertiesTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Tests the creation of a property
   *
   * @return void
   */
  public function test_create_endpoint()
  {
    $property = Property::factory()->make();
    $this->assertDatabaseCount('property', 0);
    $response = $this->post('/api/properties', $property->jsonSerialize());
    $this->assertDatabaseCount('property', 1);

    $response->assertJson($property->jsonSerialize());
    $response->assertStatus(201);
  }

  /**
   * Tests the creation validation of a property
   *
   * @return void
   */
  public function test_create_endpoint_verification_field_missing()
  {
    $this->assertDatabaseCount('property', 0);
    $response = $this->postJson('/api/properties', [
      'bedrooms' => 5,
      'garages' => 5,
      'description' => 'This is a description for test field verification',
    ]);
    $response->assertJsonValidationErrors([
      'bathrooms',
    ]);
    $response->assertStatus(422);
    $this->assertDatabaseCount('property', 0);
  }

  /**
   * Tests the creation validation of a property
   *
   * @return void
   */
  public function test_create_endpoint_verification_field_null()
  {
    $this->assertDatabaseCount('property', 0);
    $response = $this->postJson('/api/properties', [
      'bedrooms' => 5,
      'bathrooms' => 2,
      'garages' => 5,
      'description' => null,
    ]);
    $response->assertJsonValidationErrors([
      'description',
    ]);
    $response->assertStatus(422);
    $this->assertDatabaseCount('property', 0);
  }
  /**
   * Tests the creation validation of a property
   *
   * @return void
   */
  public function test_create_endpoint_verification_all_fields_missing()
  {
    $this->assertDatabaseCount('property', 0);
    $response = $this->postJson('/api/properties', []);
    $response->assertJsonValidationErrors([
      'bedrooms',
      'bathrooms',
      'garages',
      'description',
    ]);
    $response->assertStatus(422);
    $this->assertDatabaseCount('property', 0);
  }
  /**
   * Tests the list endpoint of properties route.
   *
   * @return void
   */
  public function test_list_endpoint()
  {
    $this->assertDatabaseCount('property', 0);
    $properties = Property::factory()->count(5)->create();
    $response = $this->get('/api/properties');
    $response->assertJson($properties->jsonSerialize());
    $response->assertStatus(200);
    $this->assertDatabaseCount('property', 5);
  }

  /**
   * Tests the detail endpoint of properties route.
   *
   * @return void
   */
  public function test_detail_endpoint()
  {
    $this->assertDatabaseCount('property', 0);

    $properties = Property::factory()->count(6)->create();

    $this->assertDatabaseCount('property', 6);

    $response = $this->get('/api/properties/' . $properties->offsetGet(3)->id);
    $response->assertJson($properties->offsetGet(3)->jsonSerialize());
    $response->assertStatus(200);
  }

  /**
   * Tests the update endpoint of properties route.
   *
   * @return void
   */
  public function test_update_endpoint()
  {
    $this->assertDatabaseCount('property', 0);
    $properties = Property::factory()->count(6)->create();
    $this->assertDatabaseCount('property', 6);
    $property_id = $properties->offsetGet(3)->id;
    $response = $this->put('/api/properties/' . $property_id, [
      "bedrooms" => 77
    ]);

    $updated_property = $properties->find($property_id);
    $updated_property->bedrooms = 77;

    $response->assertJson([
      'message' => 'updated property',
      'property' =>   $updated_property->jsonSerialize()
    ]);
    $response->assertStatus(200);
  }

  /**
   * Tests the delete endpoint of properties route.
   *
   * @return void
   */
  public function test_delete_endpoint()
  {
    $this->assertDatabaseCount('property', 0);
    $property = Property::factory()->create();
    $property_id = $property->id;

    $this->assertDatabaseHas('property', [
      'id' => $property_id
    ]);

    $response = $this->delete('/api/properties/' . $property_id);
    $this->assertDatabaseMissing('property', [
      'id' => $property_id
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseCount('property', 0);
  }
}
