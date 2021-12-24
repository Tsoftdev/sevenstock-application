<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedhistories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('feedname', 255)->nullable();
            $table->integer('customerId')->nullable()->unsigned();
            $table->foreign('customerId')->nullable()->references('id')->on('customers')->onDelete('cascade');
            $table->integer('createdBy')->nullable()->unsigned();
            $table->foreign('createdBy')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('feedhistories');
    }
}
