<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;
use Tests\TestCase;

class PropertyImageTest extends TestCase
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
      '/api/properties/' . $property_id . '/images',
      [
        'image' => $image,
      ]
    );
    $response->assertStatus(201);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->where('id', 1)
        ->where('image', 'images/' . $image->hashName())
        ->where('property_id', (string) $property_id)
        ->etc()
    );
    Storage::disk('public')->assertExists('images/' . $image->hashName());
  }

  public function test_list_user_images()
  {
    $property = Property::factory()
      ->create();
    $images = Image::factory()
      ->count(5)
      ->create();
    foreach ($images as $image) {
      PropertyImage::factory()
        ->state(['property_id' => $property->id])
        ->state(['image_id' => $image->id])
        ->create();
    }
    $response = $this->getJson(
      '/api/properties/' . $property->id . '/images/'
    );
    $response->assertStatus(200);
    $response->assertJson($images->jsonSerialize());
  }
}
