<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\NewsTags;
use App\Models\News;


class NewsTagsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tags = NewsTags::orderBy('id', 'desc')->get();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Tags list generated successfully.', 'data' => $tags]);
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
      'keyword' => 'required',
      'color' => 'required',
    ];

    // Messages
    $messages = [
      'keyword.required' => 'Keyword is required.',
      'color.required' => 'Color is required.',
    ];

    // Validate
    $validator = Validator::make($request->all(), $rules, $messages);

    // If validation fails
    if ($validator->fails()) {
      $messages = $validator->messages();
      // Return
      return response()->json(['status' => 'bad', 'message' => 'Validation failed.', 'data' => $validator->messages()]);
    }

    // Create
    $tag = NewsTags::create($request->all());

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Tag added successfully.', 'data' => $tag]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
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
    //
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
    $tag = NewsTags::find($id);

    foreach ($tag->news as $n) {
      $update_news = News::find($n->id);
      $update_news->tag_id = 0;
      $update_news->save();
    }

    $tag->delete();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Tag deleted successfully and removed from the associated news.', 'data' => null]);
  }
}
