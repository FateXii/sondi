<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\StandAlone;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandAloneFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = StandAlone::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'addresses_id' => Address::factory(),
    ];
  }
}
