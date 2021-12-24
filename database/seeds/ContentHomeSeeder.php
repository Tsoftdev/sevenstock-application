<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentHomeSeeder extends Seeder
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

    DB::table('content_home')->insert([
      'we_are_here' => $faker->sentence,
      'address' => $faker->address,
      'office_number' => $faker->phoneNumber,
      'fax_number' => $faker->phoneNumber,
      'email' => $faker->email,
      'map_link' => $faker->url,
      'pdf1' => $url . '/sample/sample.pdf',
      'pdf2' => $url . '/sample/sample.pdf',
      'created_at' => $faker->dateTime(),
      'updated_at' => $faker->dateTime()
    ]);
  }
}
