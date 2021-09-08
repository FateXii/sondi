<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Storage::fake('public');
        return [
            'photo' => UploadedFile::fake()
                ->image($this->faker->image())
                ->store('images'),
            'bio' => $this->faker->text(),
            'phone_number' => $this->faker->phoneNumber(),
            'user_id' => User::factory(),
            'deleted_at'=> null
        ];
    }
}
