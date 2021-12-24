<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_records', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('type',50);
            $table->string('sender',50);
            $table->integer('sms_count');
            $table->string('status',50);
            $table->integer('fail_count');
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
        Schema::dropIfExists('sms_records');
    }
}
