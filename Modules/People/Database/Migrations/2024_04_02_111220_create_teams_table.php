<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            // $table->string('team_code')->unique()->nullable();
            $table->string('nik_number');
            $table->string('team_name');
            $table->date('date_birth');
            $table->string('team_phone');
            $table->string('team_email');
            $table->enum('gender',['L','P']);
            $table->string('team_status');
            $table->string('division');
            $table->string('city');
            $table->string('country');
            $table->text('address');
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
        Schema::dropIfExists('teams');
    }
}
