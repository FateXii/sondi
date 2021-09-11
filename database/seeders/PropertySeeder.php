<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Image;
use App\Models\Property;
use App\Models\Sectionals;
use App\Models\SectionalUnit;
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
        $properties = Property::factory()->count(30)->create();
        $sectionals = Sectionals::factory()->count(5)->create();
        $visited = [false, false, false, false, false, false, false];
        foreach ($properties as  $property) {
            Image::factory()
                ->state(['property_id' => $property->id])
                ->count(rand(5, 15))
                ->create();
            $rand = rand(0, 10);
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
