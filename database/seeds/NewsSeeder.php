<?php

use App\Models\News;
use App\Models\NewsTags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
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


    // News tag
    for ($i = 0; $i <= 2; $i++) :
      DB::table('news_tags')->insert([
        'keyword' => ucfirst($faker->word),
        'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;


    // News
    for ($i = 0; $i <= 6; $i++) :
      $news_tag = NewsTags::all()->random(1)[0];
      DB::table('news')->insert([
        'title' => $faker->sentence(6),
        'description' => '<p>' . $faker->paragraph . '</p>',
        'date' => $faker->date(),
        'images' => json_encode([$url . '/sample/thumbnail.png']),
        'tag_id' => $news_tag->id,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;


    // News recommend
    $news = News::all();
    foreach ($news as $n) :
      DB::table('news_random')->insert([
        'news_id' => $n->id,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endforeach;

    for ($i = 0; $i <= 1; $i++) :
      $rand_news = News::all()->random(1)[0];
      DB::table('news_recommend')->insert([
        'news_id' => $rand_news->id,
        'box_num' => $i + 1,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now')
      ]);
    endfor;
  }
}
