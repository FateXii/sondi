<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    return [
      'bathrooms' => rand(0, 15),
      'bedrooms' => rand(0, 15),
      'garages' => rand(0, 15),
      'addresses_id' => Address::factory(),
      'description' => $this->faker->text,
    ];
  }
}
