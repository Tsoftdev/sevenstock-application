<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('companyId')->nullable()->unsigned();
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->string('status', 100)->nullable();
            $table->integer('stockPrice')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('invested')->nullable();
            $table->string('picture',100)->nullable();
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('customers')->onDelete('cascade');
            $table->integer('is_sent')->default(0);
            $table->string('createdBy', 100)->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
