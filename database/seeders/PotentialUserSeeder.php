<?php

namespace Database\Seeders;

use App\Models\PotentialUser;
use Database\Factories\PotentialUserFactory;
use Illuminate\Database\Seeder;

class PotentialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PotentialUser::factory(10)->create();
    }
}
