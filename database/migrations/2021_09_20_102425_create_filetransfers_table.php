<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiletransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filetransfers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('companyId')->nullable()->unsigned();
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->string('fileName', 100)->nullable();
            $table->string('method', 100)->nullable();
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
        Schema::dropIfExists('filetransfers');
    }
}
