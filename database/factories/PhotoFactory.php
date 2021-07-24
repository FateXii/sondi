<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;


    /**
     * Indicates that this the photo is the cover photo
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     *
     */
    public function cover() {
      return $this->state(function(){
        return [
          'cover_photo' => true,
        ];
      });
    }
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Storage::fake('public');
        return [
          'property_id' => Property::factory(),
          'cover_photo' => false,
          'image_path' => UploadedFile::fake()
            ->image($this->faker->image)->store('images'),
        ];
    }
}
