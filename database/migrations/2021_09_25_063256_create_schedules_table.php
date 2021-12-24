<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->text('note')->nullable();
            $table->integer('userId')->nullable()->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('customers')->onDelete('cascade');
            $table->string('customerName', 255)->nullable();
            $table->string('backgroundColor', 255)->nullable();
            $table->string('borderColor', 255)->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('all_day')->default(0);
            $table->boolean('is_Active')->default(1);
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
        Schema::dropIfExists('schedules');
    }
}
