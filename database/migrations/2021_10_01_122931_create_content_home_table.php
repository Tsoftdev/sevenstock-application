<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentHomeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('content_home', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->text('we_are_here')->nullable();
      $table->text('address')->nullable();
      $table->string('office_number')->nullable();
      $table->string('fax_number')->nullable();
      $table->string('email')->nullable();
      $table->string('map_link')->nullable();
      $table->string('pdf1')->nullable();
      $table->string('pdf2')->nullable();
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
    Schema::dropIfExists('home_content');
  }
}
