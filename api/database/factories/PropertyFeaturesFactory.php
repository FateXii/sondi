<?php

namespace Database\Factories;

use App\Models\Features;
use App\Models\Property;
use App\Models\PropertyFeatures;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFeaturesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PropertyFeatures::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'feature_id' => Features::factory(),
            'property_id' => Property::factory(),
            'value' => function (array $features) {
                $type = Features::find($features['feature_id'])->type;
                return $type == 'number' || $type == 'area' ? strval($this->faker->randomNumber(8)) : $this->faker->randomElement(['yes', 'no']);
            }
        ];
    }
}
