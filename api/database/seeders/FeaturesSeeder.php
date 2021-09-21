<?php

namespace Database\Seeders;

use App\Models\Features;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feature = [
            [
                'name' => 'bedrooms',
                'type' => 'number',
            ],
            [
                'name' => 'bathrooms',
                'type' => 'number',
            ],
            [
                'name' => 'interior space',
                'type' => 'number',
            ],
            [
                'name' => 'plot size',
                'type' => 'number',
            ],
            [
                'name' => 'swimming pool',
                'type' => 'boolean',
            ],
            [
                'name' => 'electric fence',
                'type' => 'boolean',
            ],
            [
                'name' => 'generator',
                'type' => 'boolean',
            ],
            [
                'name' => 'office',
                'type' => 'boolean',
            ],
            [
                'name' => 'scullary',
                'type' => 'boolean',
            ],
            [
                'name' => 'gym',
                'type' => 'boolean',
            ],
        ];
        foreach ($feature as $feat) {
            Features::factory()->state([
                'name' => $feat['name'],
                'type' => $feat['type'],
            ])->create();
        }
    }
}
