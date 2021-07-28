<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Sectionals;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SectionalsFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Sectionals::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    Storage::fake('public');
    return [
      'addresses_id' => Address::factory(),
      'name' => $this->faker->word,
      'type' => $this->faker->randomElement(
        ['apartment', 'complex']
      ),
      'image' => UploadedFile::fake()
        ->image($this->faker->image)->store('images'),
    ];
  }
}
