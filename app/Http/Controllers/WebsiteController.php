<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ContactInquiries;
use App\Models\ContentHome;
use App\Models\VisitorsReviews;
use App\Models\News;
use App\Models\Blog;
use App\Models\Consulting;
use App\Models\NewsInnerRecommend;
use App\Models\NewsRandom;
use App\Models\NewsRecommend;
use App\Models\NewsTags;
use App\Models\Banner;
use App\Models\BlogRecommend;
use App\Models\Video;
use App\Models\VideoInnerRecommend;
use App\Models\VideoRandom;
use App\Models\VideoRecommend;
use App\Models\VideoTags;

class WebsiteController extends BaseController
{
  public function index()
  {
    // Getting all reviews
    $reviews = VisitorsReviews::orderBy('id', 'desc')->limit(4)->get();

    // Home content
    $home_content = ContentHome::first();

    // Return
    return view('website.home', [
      'reviews' => $reviews,
      'we_are_here' => $home_content ? $home_content->we_are_here : null,
      'address' => $home_content ? $home_content->address : null,
      'office_number' => $home_content ? $home_content->office_number : null,
      'fax_number' => $home_content ? $home_content->fax_number : null,
      'email' => $home_content ? $home_content->email : null,
      'map_link' => $home_content ? $home_content->map_link : null,
      'pdf1' => $home_content ? $home_content->pdf1 : null,
      'pdf2' => $home_content ? $home_content->pdf2 : null,

    ]);
  }


  /**
   * Consulting
   */
  public function consultmain()
  {

    $consulting = Consulting::where('publish', 1)->get();

    return view('website.consultmain', ['consulting' => $consulting]);
  }
  public function consulting($id)
  {


    $consulting = Consulting::find($id);
    $consulting_news = $consulting->news_videos->where('type', 'news');

    if (count($consulting_news) > 0) {
      $consulting_news = $consulting->news_videos->where('type', 'news');
    }

    return view('website.consult', [
      'consulting' => $consulting,
      'consulting_news' => $consulting_news
    ]);
  }

  /**
   * Newsroom
   *
   * @return void
   */
  public function newsroom()
  {

    $news1 = NewsRecommend::where('box_num', 1)->orderBy('id', 'DESC')->first();
    $news2 = NewsRecommend::where('box_num', 2)->orderBy('id', 'DESC')->first();
    $news3 = NewsRecommend::where('box_num', 3)->orderBy('id', 'DESC')->first();
    $news4 = NewsRecommend::where('box_num', 4)->orderBy('id', 'DESC')->first();


    $newsroom_banner_1 = Banner::where(['location' => 'newsroom_banner_1'])->first();
    $newsroom_banner_2 = Banner::where(['location' => 'newsroom_banner_2'])->first();


    // News
    $news = News::all();

    // Tags
    $tags = NewsTags::all();


    return view('website.newsroom', [
      'news' => $news,
      'tags' => $tags,
      'active_tag' => null,
      'rec1' => $news1 ? $news1 : (NewsRandom::count() > 0 ? NewsRandom::all()->random(1)[0] : null),
      'rec2' => $news2 ? $news2 : (NewsRandom::count() > 0 ? NewsRandom::all()->random(1)[0] : null),
      'rec3' => $news3 ? $news3 : (NewsRandom::count() > 0 ? NewsRandom::all()->random(1)[0] : null),
      'rec4' => $news4 ? $news4 : (NewsRandom::count() > 0 ? NewsRandom::all()->random(1)[0] : null),
      'newsroom_banner_1' => $newsroom_banner_1,
      'newsroom_banner_2' => $newsroom_banner_2,
    ]);
  }

  /**
   * Newsroom Tag
   *
   * @return void
   */
  public function newsroom_tag($id)
  {

    // News
    $news = News::where('tag_id', $id)->get();

    // Tags
    $tags = NewsTags::all();

    // Tag
    $active_tag = NewsTags::find($id);

    return view('website.newsroom', [
      'news' => $news,
      'tags' => $tags,
      'active_tag' => $active_tag
    ]);
  }

  /**
   * News Detail
   *
   * @param [type] $id
   * @return void
   */
  public function news_detail($id)
  {
    // News
    $news = News::find($id);

    // News Inner Recommend
    $news_inner_recommend = NewsInnerRecommend::all();

    // Related News
    $related_news = NewsTags::find($news->tag_id);

    // return $related_news->news;

    return view('website.newsroomdetail', ['news' => $news, 'news_inner_recommend' => $news_inner_recommend, 'related_news' => $related_news->news]);
  }


  public function aboutus()
  {

    return view('website.aboutus');
  }
  public function service()
  {

    return view('website.service');
  }

  /**
   * Blog
   *
   * @return void
   */
  public function blog()
  {

    // Blog
    $blog = Blog::all();

    // Blog recommend
    $blog_recommend = BlogRecommend::all();

    $blog_banner_1 = Banner::where(['location' => 'blog_banner_1'])->first();
    $blog_banner_2 = Banner::where(['location' => 'blog_banner_2'])->first();

    return view('website.blog', [
      'blog' => $blog,
      'blog_banner_1' => $blog_banner_1,
      'blog_banner_2' => $blog_banner_2,
      'blog_recommend' => $blog_recommend
    ]);
  }
  public function blog_detail($id)
  {
    // Blog
    $blog = Blog::find($id);

    return view('website.blogdetail', ['blog' => $blog]);
  }
  public function contactus()
  {

    return view('website.contactus');
  }


  /**
   * Newsroom (Video)
   *
   * @return void
   */
  public function video()
  {

    $news1 = VideoRecommend::where('box_num', 1)->orderBy('id', 'DESC')->first();
    $news2 = VideoRecommend::where('box_num', 2)->orderBy('id', 'DESC')->first();
    $news3 = VideoRecommend::where('box_num', 3)->orderBy('id', 'DESC')->first();
    $news4 = VideoRecommend::where('box_num', 4)->orderBy('id', 'DESC')->first();
    $news5 = VideoRecommend::where('box_num', 5)->orderBy('id', 'DESC')->first();



    // Videos
    $video = Video::all();

    // Tags
    $tags = VideoTags::all();


    return view('website.video', [
      'video' => $video,
      'tags' => $tags,
      'active_tag' => null,
      'rec1' => $news1 ? $news1 : (VideoRandom::count() > 0 ? VideoRandom::all()->random(1)[0] : null),
      'rec2' => $news2 ? $news2 : (VideoRandom::count() > 0 ? VideoRandom::all()->random(1)[0] : null),
      'rec3' => $news3 ? $news3 : (VideoRandom::count() > 0 ? VideoRandom::all()->random(1)[0] : null),
      'rec4' => $news4 ? $news4 : (VideoRandom::count() > 0 ? VideoRandom::all()->random(1)[0] : null),
      'rec5' => $news5 ? $news5 : (VideoRandom::count() > 0 ? VideoRandom::all()->random(1)[0] : null),
    ]);
  }

  /**
   * Newsroom (Video) Tag
   *
   * @return void
   */
  public function video_tag($id)
  {

    // News
    $video = Video::where('tag_id', $id)->get();

    // Tags
    $tags = VideoTags::all();

    // Tag
    $active_tag = VideoTags::find($id);

    return view('website.video', [
      'video' => $video,
      'tags' => $tags,
      'active_tag' => $active_tag
    ]);
  }

  /**
   * Video Inner
   *
   * @param [type] $id
   * @return void
   */
  public function videoinner($id)
  {
    // Video
    $video = Video::find($id);

    // News Inner Recommend
    $news_inner_recommend = VideoInnerRecommend::all();

    return view('website.videoinner', [
      'video' => $video,
      'news_inner_recommend' => $news_inner_recommend,
    ]);
  }
  public function newsroomdetail()
  {

    return view('website.newsroomdetail');
  }

  // Contact request
  public function contact_request(Request $request)
  {

    // Rules
    $rules = [
      'name' => 'required',
      'company_name' => 'sometimes',
      'phone_number' => 'required',
      'inquiry' => 'sometimes',
      'inquiry_type' => 'required',
    ];

    // Messages
    $messages = [
      'name.required' => 'Name is required.',
      'company_name.required' => 'Company name is required.',
      'phone_number.required' => 'Phone number is required.',
      'inquiry.required' => 'Brief inquiry is required.',
      'inquiry_type.required' => 'Select inquiry type.',
    ];

    // Validate
    $validator = Validator::make($request->all(), $rules, $messages);

    // If validation fails
    if ($validator->fails()) {
      $messages = $validator->messages();
      return response()->json($validator->messages());
    }

    $request_data = $request->all();

    // /* Mailchimp Request */

    // $list_id = '598a8e3065';
    // $client = new \MailchimpMarketing\ApiClient();
    // $client->setConfig([
    //     'apiKey' => '2d034c1b7469ca9cf02d664bc272113b-us5',
    //     'server' => 'us5',
    // ]);

    // $response = $client->campaigns->create(["type" => "regular",
    //  'recipients' => ['list_id'=>$list_id],
    //     'settings' => [
    //         'title'=>'Testing',
    //         'subject_line'=>'Inquiry',
    //         'to_name'=> $request_data['name'],
    //         'preview_text'=>'dasdsadsadsadsadsadasd',
    //         'from_name' => 'Testing',
    //         'reply_to' => 'alishiwani97@gmail.com',
    //         'auto_footer' => true,
    //         'template_id' => 10023678
    //     ],

    // ]);
    // $client->campaigns->send($response->id);
    // dd('in');

    // /* Mailchimp Request End */



    $filepath = '';

    if ($request->file('attachment')) {

      $filename = time() . '_' . $request->file('attachment')->getClientOriginalName();

      // File upload location
      $location = 'contact-inquiry-attachments';

      // Upload file
      $request->file('attachment')->move($location, $filename);

      // File path
      $filepath = url($location . '/' . $filename);
    }

    // Create contact request
    $contact_request = ContactInquiries::create([
      'company_name' => isset($request_data['company_name']) ? $request_data['company_name'] : '',
      'name' => $request_data['name'],
      'phone_number' => $request_data['phone_number'],
      'inquiry' => isset($request_data['inquiry']) ? $request_data['inquiry'] : '',
      'inquiry_type' => $request_data['inquiry_type'],
      'attachment' => $filepath,
    ]);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Contact request successful.', 'data' => $contact_request]);
  }
}
