<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->string('street');
      $table->string('city');
      $table->string('province');
      $table->string('postal_code');
      $table->foreignId('property_id')->nullable()
        ->references('id')
        ->on('property')
        ->onDelete('cascade');
      $table->foreignId('sectionals_id')->nullable()
        ->references('id')
        ->on('sectionals')
        ->onDelete('cascade');
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
    Schema::dropIfExists('addresses');
  }
}
