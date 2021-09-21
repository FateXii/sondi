<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\SectionalUnit;
use App\Models\StandAlone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PropertyFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Property::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $images = [
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/13a1227738c1826_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/08/bae2a9f014ae88b_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/09/f57007b0dd95475_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/09/f57007b0dd95475_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/04/d82ae96216bffa3_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/03/c901cf31717a58b_t_w_1280_h_1024.jpg',
    ];
    Storage::fake('public');
    return [
      'cover_image' => $this->faker->randomElement($images),
      'description' => $this->faker->text,
      'description_title' => $this->faker->text(30),
      'title' => $this->faker->text(30),
      'video_url' => $this->faker->url,
      'is_rental' => $this->faker->boolean,
      'price' => $this->faker->randomNumber(6),
    ];
  }
}
