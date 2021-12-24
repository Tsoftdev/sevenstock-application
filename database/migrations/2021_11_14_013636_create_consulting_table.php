<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('consulting', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('company_id');
      $table->string('icon')->nullable();
      $table->string('company_name_kor')->nullable();
      $table->string('company_name_eng')->nullable();
      $table->string('title')->nullable();
      $table->string('industry')->nullable();
      $table->string('enterprise_valuation')->nullable();
      $table->string('expected_growth_rate')->nullable();
      $table->string('background_image')->nullable();
      $table->string('icon_inner')->nullable();
      $table->string('company_name_kor_inner')->nullable();
      $table->string('subtitle')->nullable();
      $table->string('company_video_link')->nullable();
      $table->string('service_video_link')->nullable();
      $table->string('user_review_video_link')->nullable();
      $table->string('industry_inner')->nullable();
      $table->text('highlight_content')->nullable();
      $table->string('market_value')->nullable();
      $table->string('ceo_name')->nullable();
      $table->string('founding_date')->nullable();
      $table->string('capital')->nullable();
      $table->string('total_shares')->nullable();
      $table->string('unified_stocks')->nullable();
      $table->string('keyword')->nullable();
      $table->string('company_website')->nullable();
      $table->text('shareholders')->nullable();
      $table->text('attachment')->nullable();
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
    Schema::dropIfExists('consulting');
  }
}
