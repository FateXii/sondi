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
    $properties = [
      '{"screen": "50 inch", "resolution": "2048 x 1152 pixels", "ports": {"hdmi": 1, "usb": 3}, "speakers": {"left": "10 watt", "right": "10 watt"}}',
      '{"screen": "30 inch", "resolution": "1600 x 900 pixles", "ports": {"hdmi": 1, "usb": 1}, "speakers": {"left": "10 watt", "right": "10 watt"}}',
      '{"screen": "20 inch", "resolution": "1280 x 720 pixels", "ports": {"hdmi": 0, "usb": 0}, "speakers": {"left": "5 watt", "right": "5 watt"}}',
    ];
    Storage::fake('public');
    return [
      'cover_image' => UploadedFile::fake()
        ->image($this->faker->image)->store('images'),
      'description' => $this->faker->text,
      'description_title' => $this->faker->text(30),
      'title' => $this->faker->text,
      'video_url' => $this->faker->url,
      'features' => $this->faker->randomElement($properties),
      'is_rental' => $this->faker->boolean,
      'price' => $this->faker->randomNumber(6),
    ];
  }
}
