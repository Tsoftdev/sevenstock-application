<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('video', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title');
      $table->longText('description');
      $table->date('date');
      $table->longText('images')->nullable();
      $table->string('video_link')->nullable();
      $table->integer('tag_id');
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
    Schema::dropIfExists('video');
  }
}
