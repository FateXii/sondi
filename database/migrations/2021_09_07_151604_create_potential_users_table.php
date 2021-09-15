<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotentialUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potential_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('phone_number')
                ->nullable()
                ->unique();
            $table->string('agent_registration_number')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_agent')->default(false);
            $table->boolean('is_tenant')->default(false);
            $table->string('photo')->nullable();
            $table->string('bio')->nullable();
            $table->string('email')->unique();
            $table->string('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('potential_users');
    }
}
