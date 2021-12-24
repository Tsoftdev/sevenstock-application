<?php

use App\Models\Company;
use App\Models\Consulting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = \Faker\Factory::create();
    $url = config('app.url');

    // If company found
    if (count(Company::all()) > 0) {

      $company = Company::all()->random(1)[0];

      // Consulting
      DB::table('consulting')->insert([
        'company_id' => $company->id,
        'publish' => 1,
        'icon' => $url . '/sample/icon.png',
        'company_name_kor' => $faker->company,
        'company_name_eng' => $faker->company,
        'title' => ucfirst($faker->sentence),
        'industry' => $faker->company,
        'enterprise_valuation' => ucfirst($faker->word),
        'expected_growth_rate' => $faker->numberBetween(100, 999),
        'background_image' => $url . '/sample/bg.png',
        'icon_inner' => $url . '/sample/icon.png',
        'company_name_kor_inner' => $faker->company,
        'subtitle' => ucfirst($faker->sentence),
        'company_video_link' => 'https://www.youtube.com/embed/K4TOrB7at0Y',
        'service_video_link' => 'https://www.youtube.com/embed/K4TOrB7at0Y',
        'user_review_video_link' => 'https://www.youtube.com/embed/K4TOrB7at0Y',
        'industry_inner' => $faker->company,
        'market_value' => $faker->numberBetween(1000, 9999),
        'ceo_name' => $faker->name,
        'founding_date' => $faker->date(),
        'capital' => $faker->numberBetween(1000, 9999),
        'total_shares' => $faker->numberBetween(10, 99),
        'unified_stocks' => ucfirst($faker->word),
        'keyword' => ucfirst($faker->word),
        'company_website' => $faker->url,
        'highlight' => '<h2>Highlight</h2><p>' . $faker->paragraph . '</p>',
        'problem' => '<h2>Problem</h2><p>' . $faker->paragraph . '</p>',
        'suggest_solution' => '<h2>Suggest a Solution</h2><p>' . $faker->paragraph . '</p>',
        'service_introduction' => '<h2>Services Introduction</h2><p>' . $faker->paragraph . '</p>',
        'service_diff_eff' => '<h2>Services Differentiation and Effectiveness</h2><p>' . $faker->paragraph . '</p>',
        'market_analysis' => '<h2>Market Analysis</h2><p>' . $faker->paragraph . '</p>',
        'business_status' => '<h2>Business Status</h2><p>' . $faker->paragraph . '</p>',
        'about_company' => '<h2>About Company</h2><p>' . $faker->paragraph . '</p>',
        'ceo' => '<h2>CEO</h2><p>' . $faker->paragraph . '</p>',
        'members' => '<h2>Members</h2><p>' . $faker->paragraph . '</p>',
        'before_after_desc' => '<p>' . $faker->text . '</p>',
        'before_consulting' => $faker->numberBetween(1000, 9999),
        'current_value' => $faker->numberBetween(1000, 9999),
        'current_value_date' => $faker->date(),
        'expectation_growth_rate' => $faker->numberBetween(1000, 9999),
        'show_red_dot_1' => 1,
        'red_dot_1_title' => ucfirst($faker->word),
        'red_dot_1_amount' => $faker->numberBetween(1000, 9999),
        'show_red_dot_2' => 1,
        'red_dot_2_title' => ucfirst($faker->word),
        'red_dot_2_amount' => $faker->numberBetween(1000, 9999),
        'show_red_dot_3' => 1,
        'red_dot_3_title' => ucfirst($faker->word),
        'red_dot_3_amount' => $faker->numberBetween(1000, 9999),
        'show_red_dot_4' => 1,
        'red_dot_4_title' => ucfirst($faker->word),
        'red_dot_4_amount' => $faker->numberBetween(1000, 9999),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
      ]);

      // Highlight Content
      for ($i = 0; $i <= 3; $i++) :
        $consulting = Consulting::orderBy('id', 'DESC')->first();
        DB::table('consulting_highlight')->insert([
          'consulting_id' => $consulting->id,
          'content' => $faker->sentence(6),
          'created_at' => $faker->dateTime(),
          'updated_at' => $faker->dateTime()
        ]);
      endfor;

      // Shareholders
      for ($i = 0; $i <= 3; $i++) :
        $consulting = Consulting::orderBy('id', 'DESC')->first();
        DB::table('consulting_shareholders')->insert([
          'consulting_id' => $consulting->id,
          'ceo' => $faker->name,
          'percent' => $faker->numberBetween(10, 99),
          'created_at' => $faker->dateTime(),
          'updated_at' => $faker->dateTime()
        ]);
      endfor;

      // Attachment
      for ($i = 0; $i <= 2; $i++) :
        $consulting = Consulting::orderBy('id', 'DESC')->first();
        DB::table('consulting_attachment')->insert([
          'consulting_id' => $consulting->id,
          'name' => 'sample.pdf',
          'attachment' => $url . '/sample/sample.pdf',
          'created_at' => $faker->dateTime(),
          'updated_at' => $faker->dateTime()
        ]);
      endfor;

      // EVS
      for ($i = 0; $i <= 4; $i++) :
        $consulting = Consulting::orderBy('id', 'DESC')->first();
        DB::table('consulting_evs')->insert([
          'consulting_id' => $consulting->id,
          'title' => $faker->sentence(6),
          'date' => $faker->date(),
          'created_at' => $faker->dateTime(),
          'updated_at' => $faker->dateTime()
        ]);
      endfor;

      // QA
      for ($i = 0; $i <= 4; $i++) :
        $consulting = Consulting::orderBy('id', 'DESC')->first();
        DB::table('consulting_qa')->insert([
          'consulting_id' => $consulting->id,
          'question' => $faker->sentence(6),
          'answer' => $faker->paragraph,
          'created_at' => $faker->dateTime(),
          'updated_at' => $faker->dateTime()
        ]);
      endfor;
    } else {

      $this->command->error('Could not find a company to assign consulting data to. Please create at least one company first.');
    }
  }
}
