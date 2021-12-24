<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInqueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inqueries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerId')->nullable()->unsigned();
            $table->foreign('customerId')->nullable()->references('id')->on('customers')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->string('keyword', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->integer('companyId')->nullable()->unsigned();
            $table->foreign('companyId')->nullable()->references('id')->on('companies')->onDelete('cascade');
            $table->string('createdBy', 30)->nullable();
            $table->integer('updatedBy')->nullable();
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
        Schema::dropIfExists('inqueries');
    }
}
