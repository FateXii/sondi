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
      $table->foreignId('addresses_id');
      $table->integer('bedrooms');
      $table->integer('bathrooms');
      $table->integer('garages');
      $table->text('description');
      $table->timestamps();

      $table->index([
        'addresses_id'
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
