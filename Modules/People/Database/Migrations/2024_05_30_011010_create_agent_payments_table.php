<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->date('date');
            $table->string('reference');
            $table->integer('amount');
            $table->string('payment_method');
            $table->string('status');
            $table->text('note')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
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
        Schema::dropIfExists('agent_payments');
    }
}
