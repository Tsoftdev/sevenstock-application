<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoTags;

class VideoController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    // Vide
    $video = Video::all();

    // Video tags
    $video_tags = VideoTags::all();

    return view('admin.change-content.news-room-video', [
      'video' => $video,
      'video_tags' => $video_tags
    ]);
  }

  /**
   * Video list ajax request response
   */
  public function get_video()
  {

    // Re-modeled video
    $remodeled_video = [];

    // Video
    $video = Video::all();

    // Get tag associated to the blog
    foreach ($video as $v) {
      $v['tag'] = Video::find($v->id)->tag;
      $remodeled_video[] = $v;
    }

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Video list.', 'data' => $remodeled_video]);
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
      'video_link' => 'required',
      // 'blog_images' => 'required',
    ];

    // Messages
    $messages = [
      'title.required' => 'Title is required.',
      'tag.required' => 'Tag is required.',
      'date.required' => 'Date is required.',
      'description.required' => 'Description is required.',
      'video_link.required' => 'Video link is required.',
      // 'blog_images.required' => 'At least upload one image.',
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

    if ($request->file('video_images') !== null) {


      foreach ($request->file('video_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'video-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create video
    $video = Video::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'date' => $request->input('date'),
      'video_link' => $request->input('video_link'),
      'tag_id' => $request->input('tag'),
      'images' =>  $images
    ]);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Video added successfully.', 'data' => $video]);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $video = Video::find($id);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Video detail retrieved.', 'data' => $video]);
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

    $video = Video::find($id);

    // Rules
    $rules = [
      'title' => 'required',
      'tag' => 'required',
      'date' => 'required',
      'description' => 'required',
      'video_link' => 'required',
    ];

    // Messages
    $messages = [
      'title.required' => 'Title is required.',
      'tag.required' => 'Tag is required.',
      'date.required' => 'Date is required.',
      'description.required' => 'Description is required.',
      'video_link.required' => 'Video link is required.',
    ];

    // Validate
    $validator = Validator::make($request->all(), $rules, $messages);

    // If validation fails
    if ($validator->fails()) {
      $messages = $validator->messages();
      // Return
      return response()->json(['status' => 'bad', 'message' => 'Validation Error!', 'data' => $messages]);
    }

    $images = $video->images;

    if ($request->file('video_images') !== null) {

      $images = [];

      foreach ($request->file('video_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'video-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create video
    $video->title = $request->input('title');
    $video->description = $request->input('description');
    $video->date = $request->input('date');
    $video->video_link = $request->input('video_link');
    $video->tag_id = $request->input('tag');
    $video->images = $images;
    $video->save();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Video updates successfully.', 'data' => $video]);
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
    $video = Video::find($id);
    $video->delete();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Video deleted successfully.', 'data' => null]);
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
}
