<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Image::class;


  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $images = [];
    for ($i = 1; $i <= 100; $i++) {
      array_push($images, "http://localhost:8000/storage/images/wall/100 Awesome Photography Wallpapers Pack-1 (" . $i . ").jpg");
    }
    return [
      'path' => $this->faker->randomElement($images),
      'property_id' => Property::factory(),
    ];
  }
}
