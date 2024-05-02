<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHajjSavingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hajj_saving_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saving_id');
            $table->date('date');
            $table->string('reference');
            $table->integer('amount');
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->foreign('saving_id')->references('id')->on('hajj_savings')->cascadeOnDelete();
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
        Schema::dropIfExists('hajj_saving_payments');
    }
}
