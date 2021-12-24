<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'WebsiteController@index');
Route::get('consultmain', 'WebsiteController@consultmain');
Route::get('consult/{id}', 'WebsiteController@consulting');
Route::get('newsroom', 'WebsiteController@newsroom');
Route::get('newsroom/{id}', 'WebsiteController@newsroom_tag');
Route::get('news/{id}', 'WebsiteController@news_detail');
Route::get('about-us', 'WebsiteController@aboutus');
Route::get('service', 'WebsiteController@service');
Route::get('blog', 'WebsiteController@blog');
Route::get('blog/{id}', 'WebsiteController@blog_detail');
Route::get('contact-us', 'WebsiteController@contactus');
Route::get('video', 'WebsiteController@video');
Route::get('video/{id}', 'WebsiteController@video_tag');
Route::get('video-inner/{id}', 'WebsiteController@videoinner');

Route::get('ping', function () {
  // $list_id = '598a8e3065';
  // $client = new MailchimpMarketing\ApiClient();
  // $client->setConfig([
  //     'apiKey' => '2d034c1b7469ca9cf02d664bc272113b-us5',
  //     'server' => 'us5',
  // ]);

  // $response = $client->campaigns->create(["type" => "regular",
  //  'recipients' => ['list_id'=>$list_id],
  //     'settings' => [
  //         'title'=>'test',
  //         'subject_line'=>'Test',
  //         'to_name'=>'alishiwani97@gmail.com',
  //         'preview_text'=>'dasdsadsadsadsadsadasd',
  //         'from_name' => 'Test',
  //         'reply_to' => 'alishiwani97@gmail.com',
  //         'auto_footer' => true,
  //         'template_id' => 10023678
  //     ],

  // ]);
  // $client->campaigns->send($response->id);
  // // dd($response);

});

// Contact
Route::post('contact/send-contact-request', 'WebsiteController@contact_request');
