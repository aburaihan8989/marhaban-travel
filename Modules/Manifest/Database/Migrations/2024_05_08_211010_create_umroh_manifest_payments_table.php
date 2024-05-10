<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUmrohManifestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umroh_manifest_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umroh_manifest_customer_id');
            $table->date('date');
            $table->string('reference');
            $table->integer('amount');
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->foreign('umroh_manifest_customer_id')->references('id')->on('umroh_manifest_customers')->cascadeOnDelete();
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
        Schema::dropIfExists('umroh_manifest_payments');
    }
}
