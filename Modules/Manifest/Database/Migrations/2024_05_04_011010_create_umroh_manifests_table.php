<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUmrohManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umroh_manifests', function (Blueprint $table) {
            $table->id();
            $table->date('register_date');
            $table->string('reference');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('status');
            $table->integer('total_price');
            $table->integer('total_payment');
            $table->integer('remaining_payment');
            $table->date('last_date');
            $table->integer('last_amount');
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
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
        Schema::dropIfExists('umroh_manifests');
    }
}