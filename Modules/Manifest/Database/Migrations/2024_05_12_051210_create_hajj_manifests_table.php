<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHajjManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hajj_manifests', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->date('register_date');
            $table->string('status');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->date('package_date');
            $table->string('package_name');
            $table->string('package_code');
            $table->string('package_departure');
            $table->string('package_days');
            $table->string('flight_route');
            $table->text('note')->nullable();
            $table->foreign('package_id')->references('id')->on('hajj_packages')->nullOnDelete();
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
        Schema::dropIfExists('hajj_manifests');
    }
}
