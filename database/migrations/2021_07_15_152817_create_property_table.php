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
      $table->text('description');
      $table->string('description_title')->nullable();
      $table->string('video_url')->nullable();
      $table->string('cover_image');
      $table->string('title');
      $table->boolean('is_rental');
      $table->unsignedBigInteger('price');
      $table->timestamps();
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
