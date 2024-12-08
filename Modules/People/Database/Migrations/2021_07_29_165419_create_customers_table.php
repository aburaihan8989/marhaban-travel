<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nik_number');
            $table->string('customer_name');
            $table->date('date_birth');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('paspor_number');
            $table->date('paspor_date');
            $table->string('customer_status');
            $table->enum('gender',['L','P']);
            $table->enum('age_group',['A','K','I']);
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
        Schema::dropIfExists('customers');
    }
}
