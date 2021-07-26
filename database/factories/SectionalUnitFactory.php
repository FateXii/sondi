<?php

namespace Database\Factories;

use App\Models\Sectionals;
use App\Models\SectionalUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionalUnitFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = SectionalUnit::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'sectionals_id' => Sectionals::factory(),
      'unit' => $this->faker->randomLetter . $this->faker->randomNumber()
    ];
  }
}
