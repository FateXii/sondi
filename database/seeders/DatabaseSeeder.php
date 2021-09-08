<?php

namespace Database\Seeders;

use App\Models\PotentialUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->createOne([
            'email'=>'test@email.com'
        ]);
        $this->call([
            PotentialUserSeeder::class,
        ]);
    }
}
