<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUmrohExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umroh_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->date('date');
            $table->string('reference');
            $table->text('details')->nullable();
            $table->double('amount');
            $table->foreign('category_id')->references('id')->on('travel_expense_categories')->restrictOnDelete();
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
        Schema::dropIfExists('umroh_expenses');
    }
}
