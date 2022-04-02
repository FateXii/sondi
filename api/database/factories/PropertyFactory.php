<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\SectionalUnit;
use App\Models\StandAlone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PropertyFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Property::class;

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
      'cover_image' => $this->faker->randomElement($images),
      'description' => $this->faker->text,
      'description_title' => $this->faker->text(30),
      'title' => $this->faker->text(30),
      'video_url' => '',
      'is_rental' => $this->faker->boolean,
      'price' => $this->faker->randomNumber(6),
    ];
  }
}
