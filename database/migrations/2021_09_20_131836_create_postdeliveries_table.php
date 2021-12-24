<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostdeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postdeliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('companyId')->nullable()->unsigned();
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('cityId')->nullable()->unsigned();
            $table->foreign('cityId')->references('id')->on('cities')->onDelete('cascade');
            $table->string('status', 100)->nullable();
            $table->text('address')->nullable();
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('postdeliveries');
    }
}
