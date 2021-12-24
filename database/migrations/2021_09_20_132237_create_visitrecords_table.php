<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->text('note')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('starttime', 100)->nullable();
            $table->string('endtime', 100)->nullable();
            $table->string('backgroundColor', 255)->nullable();
            $table->string('borderColor', 255)->nullable();
            $table->enum('type', ['T', 'A', 'E'])->default('T');
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
        Schema::dropIfExists('visitrecords');
    }
}
