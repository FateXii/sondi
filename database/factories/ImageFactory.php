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
    Storage::fake('public');
    return [
      'path' => UploadedFile::fake()
        ->image($this->faker->image)->store('images'),
      'property_id' => Property::factory(),
    ];
  }
}
