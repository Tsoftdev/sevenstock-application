<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentHome;
use App\Models\VisitorsReviews;

class HomeController extends Controller
{
  // Landing page function
  public function index()
  {

    // Get all reviews
    $reviews = VisitorsReviews::orderBy('id', 'desc')->get();

    // Home content
    $home_content = ContentHome::first();

    // Return
    return view('admin.change-content.home', [
      'reviews' => $reviews,
      'we_are_here' => $home_content ? $home_content->we_are_here : null,
      'address' => $home_content ? $home_content->address : null,
      'office_number' => $home_content ? $home_content->office_number : null,
      'fax_number' => $home_content ? $home_content->fax_number : null,
      'email' => $home_content ? $home_content->email : null,
      'map_link' => $home_content ? $home_content->map_link : null,
      'pdf1' => $home_content ? basename($home_content->pdf1) : null,
      'pdf2' => $home_content ? basename($home_content->pdf2) : null,
    ]);
  }

  // Add visitor review
  public function add_visitor_review(Request $request)
  {

    // Validate
    $validated = $request->validate([
      'review' => ['required'],
      'name' => ['required'],
      'company' => ['required'],
    ]);

    // Create review
    $review = VisitorsReviews::create([
      'review' => $validated['review'],
      'name' => $validated['name'],
      'company' => $validated['company']
    ]);

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Review has been added', 'data' => $review]);
  }


  // Update visitor review
  public function update_visitor_review(Request $request)
  {

    // Validate
    $validated = $request->validate([
      'id' => ['required'],
      'review' => ['required'],
      'name' => ['required'],
      'company' => ['required'],
    ]);

    // Find review
    $review = VisitorsReviews::find($validated['id']);

    // Update review
    $review->review = $validated['review'];
    $review->name = $validated['name'];
    $review->company = $validated['company'];

    // Save review
    $review->save();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Review has been updated', 'data' => $review]);
  }


  // Delete visitor review
  public function delete_visitor_review(Request $request)
  {
    // Validate
    $validated = $request->validate([
      'id' => ['required'],
    ]);

    VisitorsReviews::find($validated['id'])->delete();

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Review has been deleted', 'data' => null]);
  }


  // Update content
  public function update_content(Request $request)
  {

    // Check if there are records in the table
    $home_content_count = ContentHome::all()->count();

    if ($home_content_count > 0) {
      // If exists, save
      $home_content = ContentHome::first();
      $home_content->we_are_here = $request->input('we_are_here');
      $home_content->address = $request->input('address');
      $home_content->office_number = $request->input('office_number');
      $home_content->fax_number = $request->input('fax_number');
      $home_content->email = $request->input('email');
      $home_content->map_link = $request->input('map_link');

      // PDFs upload
      if (null !== $request->file('pdf1')) {
        $home_content->pdf1 = $this->uploadPDF($request->file('pdf1'));
      }
      if (null !== $request->file('pdf2')) {
        $home_content->pdf2 = $this->uploadPDF($request->file('pdf2'));
      }

      $home_content->save();
    } else {
      // Else create new record
      $home_content = ContentHome::create([
        'we_are_here' => $request->input('we_are_here'),
        'address' => $request->input('address'),
        'office_number' => $request->input('office_number'),
        'fax_number' => $request->input('fax_number'),
        'email' => $request->input('email'),
        'map_link' => $request->input('map_link'),
        'pdf1' => $this->uploadPDF($request->file('pdf1')),
        'pdf2' => $this->uploadPDF($request->file('pdf2')),
      ]);
    }

    // Return
    return response()->json(['status' => 'ok', 'message' => 'Home content has been updated.', 'data' => $home_content, 'pdf1' => basename($home_content->pdf1), 'pdf2' => basename($home_content->pdf2)]);
  }

  // Upload PDF
  public function uploadPDF($file)
  {
    if ($file) {

      $filename = time() . '_' . $file->getClientOriginalName();

      // File extension
      $extension = $file->getClientOriginalExtension();

      // File upload location
      $location = 'pdf';

      // Upload file
      $file->move($location, $filename);

      // File path
      $filepath = url($location . '/' . $filename);

      // Response
      return $filepath;
    }
  }
}