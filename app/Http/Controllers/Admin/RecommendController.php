<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogRecommend;
use App\Models\NewsInnerRecommend;
use App\Models\NewsRandom;
use App\Models\NewsRecommend;
use App\Models\VideoInnerRecommend;
use App\Models\VideoRandom;
use App\Models\VideoRecommend;

class RecommendController extends Controller
{
  // News room  function
  public function newsroom()
  {

    $random = NewsRandom::all();

    //Return
    return view('admin.change-content.recommend.news-room', [
      'news1' => NewsRecommend::where('box_num', 1)->orderBy('id', 'DESC')->first(),
      'news2' => NewsRecommend::where('box_num', 2)->orderBy('id', 'DESC')->first(),
      'news3' => NewsRecommend::where('box_num', 3)->orderBy('id', 'DESC')->first(),
      'news4' => NewsRecommend::where('box_num', 4)->orderBy('id', 'DESC')->first(),
      'random_news' => $random
    ]);
  }

  // News room inner function
  public function newsroom_inner()
  {

    $recommend = NewsInnerRecommend::all();

    //Return
    return view('admin.change-content.recommend.news-room-inner', [
      'recommend_news_inner' => $recommend
    ]);
  }

  // News room videos  function
  public function newsroomVideos()
  {

    $random = VideoRandom::all();

    //Return
    return view('admin.change-content.recommend.news-room-videos', [
      'news1' => VideoRecommend::where('box_num', 1)->orderBy('id', 'DESC')->first(),
      'news2' => VideoRecommend::where('box_num', 2)->orderBy('id', 'DESC')->first(),
      'news3' => VideoRecommend::where('box_num', 3)->orderBy('id', 'DESC')->first(),
      'news4' => VideoRecommend::where('box_num', 4)->orderBy('id', 'DESC')->first(),
      'news5' => VideoRecommend::where('box_num', 5)->orderBy('id', 'DESC')->first(),
      'random_news' => $random
    ]);
  }

  // Video room inner function
  public function video_inner()
  {

    $recommend = VideoInnerRecommend::all();

    //Return
    return view('admin.change-content.recommend.news-room-video-inner', [
      'recommend_news_inner' => $recommend
    ]);
  }


  // Blog function
  public function blog()
  {

    $recommend = BlogRecommend::all();

    //Return
    return view('admin.change-content.recommend.blog', [
      'recommend_news_inner' => $recommend
    ]);
  }

  // Consulting function
  public function consulting()
  {

    //Return
    return view('admin.change-content.recommend.consulting-list');
  }

  // Add recommend news
  public function add_news_recommend()
  {

    $news_id = $_POST['news'];
    $box_id = $_POST['box'];

    NewsRecommend::create([
      'news_id' => $news_id,
      'box_num' => $box_id
    ]);

    // Return
    return back();
  }


  // Add unrecommend news
  public function add_news_unrecommend($id)
  {

    $recommend = NewsRecommend::find($id);
    $recommend->delete();

    // Return
    return back();
  }

  // Add random news
  public function add_news_random()
  {

    $news_id = $_POST['news'];

    NewsRandom::create(['news_id' => $news_id]);

    // Return
    return back();
  }

  // Delete random news
  public function del_news_random($id)
  {

    $recommend = NewsRandom::find($id);
    $recommend->delete();

    // Return
    return back();
  }

  // Add news inner recommend
  public function add_news_inner_recommend()
  {

    $news_id = $_POST['news'];

    NewsInnerRecommend::create(['news_id' => $news_id]);

    // Return
    return back();
  }

  // Delete news inner recommend
  public function del_news_inner_recommend($id)
  {

    $recommend = NewsInnerRecommend::find($id);
    $recommend->delete();

    // Return
    return back();
  }


  // Add video inner recommend
  public function add_video_inner_recommend()
  {

    $video_id = $_POST['news'];

    VideoInnerRecommend::create(['video_id' => $video_id]);

    // Return
    return back();
  }

  // Delete video inner recommend
  public function del_video_inner_recommend($id)
  {

    $recommend = VideoInnerRecommend::find($id);
    $recommend->delete();

    // Return
    return back();
  }


  // Add recommend video
  public function add_video_recommend()
  {

    $video_id = $_POST['news'];
    $box_id = $_POST['box'];

    VideoRecommend::create([
      'video_id' => $video_id,
      'box_num' => $box_id
    ]);

    // Return
    return back();
  }


  // Add unrecommend video
  public function add_video_unrecommend($id)
  {

    $recommend = VideoRecommend::find($id);
    $recommend->delete();

    // Return
    return back();
  }

  // Add random video
  public function add_video_random()
  {

    $video_id = $_POST['news'];

    VideoRandom::create(['video_id' => $video_id]);

    // Return
    return back();
  }

  // Delete random video
  public function del_video_random($id)
  {

    $recommend = VideoRandom::find($id);
    $recommend->delete();

    // Return
    return back();
  }


  // Add blog recommend
  public function add_blog_recommend()
  {

    $blog_id = $_POST['news'];

    BlogRecommend::create(['blog_id' => $blog_id]);

    // Return
    return back();
  }

  // Delete blog recommend
  public function del_blog_recommend($id)
  {

    $recommend = BlogRecommend::find($id);
    $recommend->delete();

    // Return
    return back();
  }
}
