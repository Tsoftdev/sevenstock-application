<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsInnerRecommend;
use App\Models\NewsRandom;
use App\Models\NewsRecommend;
use App\Models\NewsTags;

class NewsRoomController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    // News
    $news = News::all();

    // News tags
    $news_tags = NewsTags::all();

    return view('admin.change-content.news-room-content', [
      'news' => $news,
      'news_tags' => $news_tags
    ]);
  }

  /**
   * News list ajax request response
   */
  public function get_news()
  {

    // Re-modeled news
    $remodeled_news = [];

    // News
    $news = News::all();

    // Get tag associated to the news
    foreach ($news as $n) {
      $n['tag'] = News::find($n->id)->tag;
      $remodeled_news[] = $n;
    }

    // Return
    return response()->json(['status' => 'ok', 'message' => 'News list.', 'data' => $remodeled_news]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    // Rules
    $rules = [
      'title' => 'required',
      'tag' => 'required',
      'date' => 'required',
      'description' => 'required',
      // 'news_images' => 'required',
    ];

    // Messages
    $messages = [
      'title.required' => 'Title is required.',
      'tag.required' => 'Tag is required.',
      'date.required' => 'Date is required.',
      'description.required' => 'Description is required.',
      // 'news_images.required' => 'At least upload one image.',
    ];

    // Validate
    $validator = Validator::make($request->all(), $rules, $messages);

    // If validation fails
    if ($validator->fails()) {
      $messages = $validator->messages();
      // Return
      return response()->json(['status' => 'bad', 'message' => 'Validation Error!', 'data' => $messages]);
    }

    $images = [];

    if ($request->file('news_images') !== null) {


      foreach ($request->file('news_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'news-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create news
    $news = News::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'date' => $request->input('date'),
      'tag_id' => $request->input('tag'),
      'images' =>  $images
    ]);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'News added successfully.', 'data' => $news]);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $news = News::find($id);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'News detail retrieved.', 'data' => $news]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    $news = News::find($id);

    // Rules
    $rules = [
      'title' => 'required',
      'tag' => 'required',
      'date' => 'required',
      'description' => 'required',
    ];

    // Messages
    $messages = [
      'title.required' => 'Title is required.',
      'tag.required' => 'Tag is required.',
      'date.required' => 'Date is required.',
      'description.required' => 'Description is required.',
    ];

    // Validate
    $validator = Validator::make($request->all(), $rules, $messages);

    // If validation fails
    if ($validator->fails()) {
      $messages = $validator->messages();
      // Return
      return response()->json(['status' => 'bad', 'message' => 'Validation Error!', 'data' => $messages]);
    }

    $images = $news->images;

    if ($request->file('news_images') !== null) {

      $images = [];

      foreach ($request->file('news_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'news-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create news
    $news->title = $request->input('title');
    $news->description = $request->input('description');
    $news->date = $request->input('date');
    $news->tag_id = $request->input('tag');
    $news->images = $images;
    $news->save();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'News updates successfully.', 'data' => $news]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    // Find and delete
    $news = News::find($id);
    $news->delete();

    $news_random = NewsRandom::where(['news_id' => $id]);
    $news_random->delete();

    $news_recommend = NewsRecommend::where(['news_id' => $id]);
    $news_recommend->delete();

    $news_inner_recommend = NewsInnerRecommend::where(['news_id' => $id]);
    $news_inner_recommend->delete();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'News deleted successfully.', 'data' => null]);
  }


  // Upload images
  public function upload(Request $request)
  {
    $fileName = $request->file('file')->getClientOriginalName();
    $path = $request->file('file')->storeAs('uploads', $fileName, 'public');
    return response()->json(['location' => "/storage/$path"]);

    /*$imgpath = request()->file('file')->store('uploads', 'public'); 
    return response()->json(['location' => "/storage/$imgpath"]);*/
  }


  // Delete news
  public function delete_news()
  {
    if (isset($_POST['news'])) {
      foreach ($_POST['news'] as $news_id) {
        $news = News::find($news_id);
        $news->delete();

        $news_random = NewsRandom::where(['news_id' => $news_id]);
        $news_random->delete();

        $news_recommend = NewsRecommend::where(['news_id' => $news_id]);
        $news_recommend->delete();

        $news_inner_recommend = NewsInnerRecommend::where(['news_id' => $news_id]);
        $news_inner_recommend->delete();
      }
    }

    return redirect()->back();
  }
}
