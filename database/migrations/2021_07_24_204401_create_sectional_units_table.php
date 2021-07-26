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
      $table->foreignId('sectionals_id');
      $table->string('unit');
      $table->timestamps();

      $table->index('sectionals_id');
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
