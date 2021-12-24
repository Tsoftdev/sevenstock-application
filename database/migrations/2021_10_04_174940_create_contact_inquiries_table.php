<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactInquiriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('contact_inquiries', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('company_name')->nullable();
      $table->string('phone_number');
      $table->longText('inquiry')->nullable();
      $table->string('inquiry_type');
      $table->string('attachment')->nullable();
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
    Schema::dropIfExists('contact_inquiries');
  }
}
