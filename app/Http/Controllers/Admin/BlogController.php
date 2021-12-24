<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogTags;

class BlogController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    // Blog
    $blog = Blog::all();

    // Blog tags
    $blog_tags = BlogTags::all();

    return view('admin.change-content.blog', [
      'blog' => $blog,
      'blog_tags' => $blog_tags
    ]);
  }

  /**
   * Blog list ajax request response
   */
  public function get_blog()
  {

    // Re-modeled blog
    $remodeled_blog = [];

    // Blog
    $blog = Blog::all();

    // Get tag associated to the blog
    foreach ($blog as $b) {
      $b['tag'] = Blog::find($b->id)->tag;
      $remodeled_blog[] = $b;
    }

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Blog list.', 'data' => $remodeled_blog]);
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
      // 'blog_images' => 'required',
    ];

    // Messages
    $messages = [
      'title.required' => 'Title is required.',
      'tag.required' => 'Tag is required.',
      'date.required' => 'Date is required.',
      'description.required' => 'Description is required.',
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

    if ($request->file('blog_images') !== null) {


      foreach ($request->file('blog_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'blog-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create blog
    $blog = Blog::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'date' => $request->input('date'),
      'tag_id' => $request->input('tag'),
      'images' =>  $images
    ]);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Blog added successfully.', 'data' => $blog]);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $blog = Blog::find($id);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Blog detail retrieved.', 'data' => $blog]);
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

    $blog = Blog::find($id);

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

    $images = $blog->images;

    if ($request->file('blog_images') !== null) {

      $images = [];

      foreach ($request->file('blog_images') as $image) {

        $filename = time() . '_' . $image->getClientOriginalName();

        // File upload location
        $location = 'blog-images';

        // Upload file
        $image->move($location, $filename);

        // File path
        $filepath = url($location . '/' . $filename);

        $images[] = $filepath;
      }
    }

    // Create blog
    $blog->title = $request->input('title');
    $blog->description = $request->input('description');
    $blog->date = $request->input('date');
    $blog->tag_id = $request->input('tag');
    $blog->images = $images;
    $blog->save();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Blog updates successfully.', 'data' => $blog]);
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
    $blog = Blog::find($id);
    $blog->delete();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Blog deleted successfully.', 'data' => null]);
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