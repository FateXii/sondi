<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;
use Tests\TestCase;

class PhotosTest extends TestCase
{
  use RefreshDatabase;
  use CreatesApplication;
  /**
   * Test image creation endpoint
   *
   * @return void
   */
  public function test_create()
  {
    Storage::fake('public');
    $image = UploadedFile::fake()
      ->image('image.png');

    $property = Property::factory()->create();
    $property_id = $property->id;

    $response = $this->postJson(
      '/api/properties/' . $property_id . '/photos',
      [
        'cover_photo' => true,
        'image' => $image,
      ]
    );
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', 1)
        ->where('image_path', 'images/' . $image->hashName())
        ->where('property_id', (string) $property_id)
        ->etc()
    );
    Storage::disk('public')->assertExists('images/' . $image->hashName());
    $response->assertStatus(201);
  }

  public function test_retrieve_incorrect_user_images()
  {
    $property1 = Property::factory()
      ->state(['id' => 1])
      ->create();
    $images1 = Photo::factory()
      ->count(5)
      ->for($property1)
      ->create();
    $response = $this->getJson(
      '/api/properties/1/photos/'
    );
    $response->assertStatus(200);
    $response->assertJson($images1->jsonSerialize());

    $property2 = Property::factory()
      ->state(['id' => 2])
      ->create();
    $images2 = Photo::factory()
      ->count(5)
      ->for($property2)
      ->create();
    $response = $this->getJson('/api/properties/2/photos/');
    $response->assertStatus(200);
    $response->assertJson($images2->jsonSerialize());
  }
  public function test_detail()
  {
    $property = Property::factory()
      ->state(['id' => 1])->create();
    $image = Photo::factory()
      ->for($property)
      ->create();
    $images = Photo::factory()
      ->count(5)
      ->for($property)
      ->create();
    $image_id = $image->id;
    $response = $this->getJson(
      '/api/properties/1/photos/' . $image_id
    );
    $response->assertStatus(200);
    $response->assertJson($image->jsonSerialize());
  }

  public function test_list()
  {
    $property = Property::factory()
      ->state(['id' => 1])
      ->create();
    $images = Photo::factory()
      ->count(5)
      ->for($property)
      ->create();
    $response = $this->getJson('/api/properties/1/photos/');
    $response->assertStatus(200);
    $response->assertJson($images->jsonSerialize());
  }
}
