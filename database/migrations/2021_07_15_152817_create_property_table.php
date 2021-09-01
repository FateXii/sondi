<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('property', function (Blueprint $table) {
      $table->id();
      $table->integer('bedrooms');
      $table->integer('bathrooms');
      $table->integer('garages');
      $table->text('description');
      $table->foreignId('stand_alones_id')->nullable();
      $table->foreignId('sectional_units_id')->nullable();
      $table->string('video_url')->nullable();
      $table->string('cover_image');
      $table->timestamps();

      $table->index([
        'stand_alones_id',
        'sectional_units_id'
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
    Schema::dropIfExists('property');
  }
}
