<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()
                ->references('id')
                ->on('property')
                ->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()
                ->references('id')
                ->on('user_profiles')
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
        Schema::dropIfExists('property_agents');
    }
}
