<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHajjManifestCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hajj_manifest_customers', function (Blueprint $table) {
            $table->id();
            $table->date('register_date');
            $table->string('reference');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('manifest_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('status');
            $table->double('total_price');
            $table->double('total_payment');
            $table->double('remaining_payment');
            $table->date('last_date');
            $table->double('last_amount');
            $table->string('payment_method');
            $table->tinyInteger('ticket');
            $table->tinyInteger('visa');
            $table->tinyInteger('big_suitcase');
            $table->tinyInteger('small_suitcase');
            $table->tinyInteger('small_bag');
            $table->tinyInteger('clothes');
            $table->tinyInteger('small_pillow');
            $table->tinyInteger('scraf');
            $table->text('note')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->foreign('manifest_id')->references('id')->on('umroh_manifests')->nullOnDelete();
            $table->foreign('package_id')->references('id')->on('umroh_packages')->nullOnDelete();
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
        Schema::dropIfExists('hajj_manifest_customers');
    }
}
