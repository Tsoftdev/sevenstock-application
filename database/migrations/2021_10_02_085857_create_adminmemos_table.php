<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminmemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminmemos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->nullable()->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->string('createdBy', 30)->nullable();
            $table->enum('isRead', ['Y', 'N'])->default('N');
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
        Schema::dropIfExists('adminmemos');
    }
}
