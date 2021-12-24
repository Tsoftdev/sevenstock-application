<?php

use App\Models\BlogTags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
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

    // Blog tag
    for ($i = 0; $i <= 2; $i++) :
      DB::table('blog_tags')->insert([
        'keyword' => ucfirst($faker->word),
        'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;


    // Blog
    for ($i = 0; $i <= 6; $i++) :
      $blog_tag = BlogTags::all()->random(1)[0];
      DB::table('blog')->insert([
        'title' => ucfirst($faker->sentence),
        'description' => '<p>' . $faker->paragraph . '</p>',
        'date' => $faker->date(),
        'images' => json_encode([$url . '/sample/thumbnail.png']),
        'tag_id' => $blog_tag->id,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;
  }
}
