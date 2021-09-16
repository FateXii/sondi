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
            'bedrooms',
            'bathrooms',
            'interior space',
            'plot size',
            'swimming pool',
            'electric fencte',
            'generator',
        ];
        foreach ($feature as $feat) {
            Features::factory()->state([
                'feature' => $feat,
            ])->create();
        }
    }
}
