<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Features;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyAgent;
use App\Models\PropertyFeatures;
use App\Models\Sectionals;
use App\Models\SectionalUnit;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
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
            'electric fence',
            'generator',
            'office',
            'scullary',
            'gym',
        ];
        $features = [];
        foreach ($feature as $feat) {
            array_push(
                $features,
                Features::factory()->state([
                    'feature' => $feat,
                ])->create()
            );
        }
        $agents = UserProfile::factory()->state([
            'is_agent' => true
        ])->count(10)->create();
        $properties = Property::factory()->count(30)->create();
        $sectionals = Sectionals::factory()->count(5)->create();
        $visited = [false, false, false, false, false, false, false];
        foreach ($properties as  $property) {
            Image::factory()
                ->state(['property_id' => $property->id])
                ->count(rand(5, 15))
                ->create();
            $rand = rand(0, 9);
            $agents_visited = [];
            $featuresUsed = [];
            for ($i = 0; $i < 5; $i++) {
                $rand1 = rand(0, 9);
                while (in_array($rand1, $agents_visited)) {
                    $rand1 = rand(0, 9);
                }
                array_push($agents_visited, $rand1);
                PropertyAgent::factory()->state([
                    'property_id' => $property->id,
                    'agent_id' => $agents[$rand1]->id,
                ])->create();
                while (in_array($rand1, $featuresUsed)) {
                    $rand1 = rand(0, 9);
                }
                array_push($featuresUsed, $rand1);
                PropertyFeatures::factory()->state(
                    [
                        'feature_id' => $features[$rand1]->id,
                        'property_id' => $property->id
                    ]
                )->create();
            }
            if ($rand < 5) {
                $sectional = $sectionals[$rand];
                if (!$visited[$rand]) {
                    Address::factory()
                        ->state([
                            'sectionals_id' => $sectional->id,
                            'property_id' => $property->id
                        ])->createOne();
                    $visited[$rand] = true;
                }
                SectionalUnit::factory()
                    ->state([
                        'sectionals_id' => $sectional->id,
                        'property_id' => $property->id
                    ])->createOne();
            } else {
                Address::factory()
                    ->state([
                        'property_id' => $property->id,
                        'sectionals_id' => null,
                    ])->createOne();
            }
        }
    }
}
