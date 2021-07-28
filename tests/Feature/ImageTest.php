<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;
use Tests\TestCase;

class ImageTest extends TestCase
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

    $response = $this->postJson(
      '/api/images/',
      [
        'image' => $image,
      ]
    );
    $response->assertStatus(201);
    $response->assertJson(
      fn (AssertableJson $json) =>
      $json->has('id')
        ->where('path', 'images/' . $image->hashName())
        ->etc()
    );
    Storage::disk('public')->assertExists('images/' . $image->hashName());
  }

  public function test_detail()
  {

    $images = Image::factory()
      ->count(5)
      ->create();
    $image = $images->offsetGet(3);
    $image_id = $image->id;
    $response = $this->getJson(
      '/api/images/' . $image_id
    );
    $response->assertStatus(200);
    $response->assertJson($image->jsonSerialize());
  }

  public function test_list()
  {
    $images = Image::factory()
      ->count(5)
      ->create();
    $response = $this->getJson('/api/images');
    $response->assertStatus(200);
    $response->assertJson($images->jsonSerialize());
  }
}
