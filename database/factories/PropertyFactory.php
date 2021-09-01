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
    Storage::fake('public');
    return [
      'bathrooms' => rand(0, 15),
      'bedrooms' => rand(0, 15),
      'garages' => rand(0, 15),
      'cover_image' => UploadedFile::fake()
        ->image($this->faker->image)->store('images'),
      'sectional_units_id' => SectionalUnit::factory(),
      'stand_alones_id' => StandAlone::factory(),
      'description' => $this->faker->text,
      'video_url' => $this->faker->url,
    ];
  }
}
