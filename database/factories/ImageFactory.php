<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Image::class;


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
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/2416b370ee1c4cc_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/6cd10746a0a0241_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/41a1851fb6eee14_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/3c50a7c38d185b5_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/0024741e582ba5a_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/7e7b343fc11421b_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/34f0162dcbdb73e_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/f83ee5d1fa713c1_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/c6a042f27bbbbaa_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/83b1010a85f6454_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/25f0334b52edf99_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/0a7314f6b72bfe4_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/b3e5c1e60d5f81f_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/f73c504e4b287ed_t_w_1280_h_1024.jpg',
      'https://d3k5w9i1vqhb0k.cloudfront.net/uploads/listings/2021/07/204f1b1c81dbe67_t_w_1280_h_1024.jpg',
    ];
    return [
      'path' => $this->faker->randomElement($images),
      'property_id' => Property::factory(),
    ];
  }
}
