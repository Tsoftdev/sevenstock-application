<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitcustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitcustomers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitId')->nullable()->unsigned();
            $table->foreign('visitId')->nullable()->references('id')->on('visitrecords')->onDelete('cascade');
            $table->integer('customerId')->nullable()->unsigned();
            $table->foreign('customerId')->nullable()->references('id')->on('customers')->onDelete('cascade');
            $table->string('status', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitcustomers');
    }
}
