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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'bio' => $this->faker->text(),
            'phone_number' => $this->faker->phoneNumber(),
            'is_admin' => $this->faker->boolean,
            'is_agent' => $this->faker->boolean,
            'is_tenant' => $this->faker->boolean(70),
            'agent_registration_number' => $this->faker->text(10),
        ];
    }
}
