<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultingNewsVideosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('consulting_news_videos', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('consulting_id');
      $table->integer('nv_id');
      $table->string('type');
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
    Schema::dropIfExists('consulting_news_videos');
  }
}
