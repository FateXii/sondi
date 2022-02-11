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
      'https://cdn.pixabay.com/photo/2016/08/01/10/37/lichtraum-1560788_960_720.jpg',
      'https://cdn.pixabay.com/photo/2018/10/28/12/44/interior-3778708_960_720.jpg',
      'https://cdn.pixabay.com/photo/2015/10/20/18/57/furniture-998265_960_720.jpg',
      'https://cdn.pixabay.com/photo/2014/08/11/21/40/bedroom-416062_960_720.jpg',
      'https://cdn.pixabay.com/photo/2014/12/27/14/37/living-room-581073_960_720.jpg',
      'https://cdn.pixabay.com/photo/2017/01/07/17/48/interior-1961070_960_720.jpg',
      'https://cdn.pixabay.com/photo/2016/11/30/08/48/bedroom-1872196_960_720.jpg',
      'https://pixabay.com/get/ge3244ee3a0c37f30c436993184a28d53da6c68f5fc74de4150530fea9049430c67159a3ac65395fabee913e71de5e049b2025b2d1f29e4f783bb908f07a2e614_1920.jpg',
      'https://pixabay.com/get/gc3034fec0908e6c1d9278d53fb69bf71c5b00c8ec0b88e9ef162b98fc59fe274bd30807d9900fd8d527c5fff4a670f6e.jpg',
      'https://pixabay.com/get/g4214db8cf594215be8ae874ed97f33c48d7fd9e6c8127d6ba0ba98a91afa632067e588c1d8afba842bebdd8843c6308c.jpg',
      'https://pixabay.com/get/g5297a9634b63d33b25ac2114e1992ca8dd3da926830ec54486e0e16cd551c32e9f23f5cdeac5b3922c89d922dba13ca11ca864aadf7fe11210ad2596636aaa97_1920.jpg',
      'https://pixabay.com/get/g7705840f107bd669851be710ab26c880b9f7efea69c3e39c1f60b727f3192dd9de4b597fabf7812459dd1ca09d5eb6f7dcb76c210ea4ceca99305ab76a6b7e2e_1920.jpg',
      'https://pixabay.com/get/gcbe84e4793afc20236f6b313b7f6929e20b1c5cbc3959796951d207e616cd71af5f8238dd84a44e8cfbc27216074166d_1920.jpg',
    ];
    return [
      'path' => $this->faker->randomElement($images),
      'property_id' => Property::factory(),
    ];
  }
}
