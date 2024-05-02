<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUmrohPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umroh_packages', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('category_id');
            $table->string('package_name');
            $table->string('package_code')->unique()->nullable();
            // $table->string('product_barcode_symbology')->nullable();
            $table->integer('package_capacity');
            $table->string('package_departure');
            $table->string('package_days');
            $table->date('package_date');
            $table->string('flight_route');
            $table->string('package_type');
            $table->string('hotel_makkah');
            $table->string('hotel_madinah');
            $table->string('package_status');
            $table->integer('package_cost');
            $table->integer('package_price');
            // $table->integer('product_order_tax')->nullable();
            // $table->tinyInteger('product_tax_type')->nullable();
            $table->text('package_include')->nullable();
            $table->text('package_exclude')->nullable();
            $table->text('package_term')->nullable();
            // $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete();
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
        Schema::dropIfExists('umroh_packages');
    }
}
