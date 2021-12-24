<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultingShareholdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('consulting_shareholders', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('consulting_id');
      $table->text('ceo');
      $table->string('percent');
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
    Schema::dropIfExists('consulting_shareholders');
  }
}
