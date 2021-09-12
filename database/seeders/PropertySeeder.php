<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyAgent;
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
            for ($i = 0; $i < 5; $i++) {
                $agents_visited = [];
                $rand1 = rand(0, 9);
                while (in_array($rand1, $agents_visited)) {
                    $rand1 = rand(0, 9);
                }
                array_push($agents_visited, $rand1);
                PropertyAgent::factory()->state([
                    'property_id' => $property->id,
                    'agent_id' => $agents[$rand1]->id,
                ])->create();
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
