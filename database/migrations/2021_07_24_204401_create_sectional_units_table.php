<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionalUnitsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sectional_units', function (Blueprint $table) {
      $table->id();
      $table->foreignId('sectional_id')
        ->references('id')
        ->on('sectionals')
        ->onDelete('cascade');
      $table->foreignId('property_id')
        ->references('id')
        ->on('property')
        ->onDelete('cascade');
      $table->string('unit');
      $table->timestamps();

      $table->index('sectional_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('sectional_units');
  }
}
