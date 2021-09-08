<?php

namespace Database\Factories;

use App\Models\PotentialUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class PotentialUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PotentialUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
