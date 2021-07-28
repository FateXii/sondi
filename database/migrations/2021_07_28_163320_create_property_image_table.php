<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyImageTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('property_image', function (Blueprint $table) {
      $table->id();
      $table->foreignId('property_id');
      $table->foreignId('image_id');
      $table->timestamps();

      $table->index([
        'property_id',
        'image_id'
      ]);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('property_images');
  }
}
