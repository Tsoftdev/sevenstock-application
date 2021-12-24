<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorReviewSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $faker = \Faker\Factory::create();

    for ($i = 0; $i <= 2; $i++) :
      DB::table('visitors_reviews')->insert([
        'name' => $faker->name,
        'company' => $faker->company,
        'review' => $faker->text,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;
  }
}
