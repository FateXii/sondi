<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;
use function rand;

class SalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sales::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'property_id' => Property::factory(),
          'price' => $this->faker->randomFloat(2, 0.0, 100000.00),
        ];
    }
}
