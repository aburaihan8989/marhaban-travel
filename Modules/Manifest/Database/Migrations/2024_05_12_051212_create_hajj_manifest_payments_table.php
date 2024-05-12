<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHajjManifestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hajj_manifest_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hajj_manifest_customer_id');
            $table->date('date');
            $table->string('reference');
            $table->integer('amount');
            $table->string('payment_method');
            $table->string('status');
            $table->text('note')->nullable();
            $table->foreign('hajj_manifest_customer_id')->references('id')->on('hajj_manifest_customers')->cascadeOnDelete();
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
        Schema::dropIfExists('hajj_manifest_payments');
    }
}
