<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Rentals;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalsFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Rentals::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'property_id' => Property::factory(),
      'price' => $this->faker->randomFloat(2, 0.00, 1000000.00),
    ];
  }
}
