<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConsultingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('consulting', function ($table) {
      $table->dropColumn('attachment');
      $table->dropColumn('shareholders');
      $table->dropColumn('highlight_content');
      $table->longText('members')->nullable()->after('company_website');
      $table->longText('ceo')->nullable()->after('company_website');
      $table->longText('about_company')->nullable()->after('company_website');
      $table->longText('business_status')->nullable()->after('company_website');
      $table->longText('market_analysis')->nullable()->after('company_website');
      $table->longText('service_diff_eff')->nullable()->after('company_website');
      $table->longText('service_introduction')->nullable()->after('company_website');
      $table->longText('suggest_solution')->nullable()->after('company_website');
      $table->longText('problem')->nullable()->after('company_website');
      $table->longText('highlight')->nullable()->after('company_website');
      
      $table->tinyInteger('publish')->default(0)->after('company_id');
      $table->string('red_dot_4_amount')->nullable()->after('members');
      $table->string('red_dot_4_title')->nullable()->after('members');
      $table->tinyInteger('show_red_dot_4')->default(0)->after('members');
      $table->string('red_dot_3_amount')->nullable()->after('members');
      $table->string('red_dot_3_title')->nullable()->after('members');
      $table->tinyInteger('show_red_dot_3')->default(0)->after('members');
      $table->string('red_dot_2_amount')->nullable()->after('members');
      $table->string('red_dot_2_title')->nullable()->after('members');
      $table->tinyInteger('show_red_dot_2')->default(0)->after('members');
      $table->string('red_dot_1_amount')->nullable()->after('members');
      $table->string('red_dot_1_title')->nullable()->after('members');
      $table->tinyInteger('show_red_dot_1')->default(0)->after('members');
      $table->string('expectation_growth_rate')->nullable()->after('members');
      $table->string('current_value_date')->nullable()->after('members');
      $table->string('current_value')->nullable()->after('members');
      $table->string('before_consulting')->nullable()->after('members');
      $table->longText('before_after_desc')->nullable()->after('members');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }
}
