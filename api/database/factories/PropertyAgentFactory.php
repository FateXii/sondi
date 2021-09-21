<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyAgent;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyAgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PropertyAgent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_id' => Property::factory(),
            'agent_id' => UserProfile::factory(),
        ];
    }
}
