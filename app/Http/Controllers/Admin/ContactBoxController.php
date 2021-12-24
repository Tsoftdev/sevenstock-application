<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactInquiries;

class ContactBoxController extends Controller
{
  // Investor landing page function
  public function investor()
  {
    // Return
    return view('admin.contact-box.investor');
  }

  // Company landing page function
  public function company()
  {
    // Return
    return view('admin.contact-box.company');
  }

  // Get Inquires
  public function get_inquiries($inquire_type)
  {
    // Get inquiries
    $inquiries = ContactInquiries::where(['inquiry_type' => $inquire_type])->orderBy('created_at', 'DESC')->get();

    // Return
    return response()->json(['status' => 'ok', 'message' => '', 'data' => $inquiries]);
  }


  // Delete inquiries
  public function delete_inquiries(Request $request)
  {
    // Get ids
    $request = $request->all();

    foreach ($request['ids'] as $id) {

      ContactInquiries::find($id)->delete();
    }



    // Return
    return response()->json(['status' => 'ok', 'message' => '', 'data' => ['all_inquiries_count' => total_inquiries_count(''), 'investor_inquiries_count' => total_inquiries_count('Investor'), 'company_inquiries_count' => total_inquiries_count('Company')]]);
  }


  // Read
  public function read_inquiry($id)
  {
    $contact = ContactInquiries::find($id);

    $contact->read = 1;

    $contact->save();

    return redirect()->back();
  }

  // Unread
  public function unread_inquiry($id)
  {
    $contact = ContactInquiries::find($id);

    $contact->read = 0;

    $contact->save();

    return redirect()->back();
  }


  // Unread
  public function read_inquiries()
  {

    if (isset($_POST['inquiries'])) {

      foreach ($_POST['inquiries'] as $inquiry) {
        $contact = ContactInquiries::find($inquiry);
        $contact->read = 1;
        $contact->save();
      }

      return redirect()->back();
    } else {
      return redirect()->back();
    }
  }
}
