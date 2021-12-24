<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
  //Displaying banner listing
  public function index()
  {

    $newsroom_banner_1 = Banner::where(['location' => 'newsroom_banner_1'])->first();
    $newsroom_banner_2 = Banner::where(['location' => 'newsroom_banner_2'])->first();
    $blog_banner_1 = Banner::where(['location' => 'blog_banner_1'])->first();
    $blog_banner_2 = Banner::where(['location' => 'blog_banner_2'])->first();

    // return
    return view('admin.change-content.banner', [
      'newsroom_banner_1' => $newsroom_banner_1,
      'newsroom_banner_2' => $newsroom_banner_2,
      'blog_banner_1' => $blog_banner_1,
      'blog_banner_2' => $blog_banner_2,
    ]);
  }

  // Save banner
  public function store()
  {

    $newsroom_banner_1 = Banner::where(['location' => 'newsroom_banner_1'])->first();
    $newsroom_banner_2 = Banner::where(['location' => 'newsroom_banner_2'])->first();
    $blog_banner_1 = Banner::where(['location' => 'blog_banner_1'])->first();
    $blog_banner_2 = Banner::where(['location' => 'blog_banner_2'])->first();

    // Newsroom banner 1
    if ($newsroom_banner_1) {
      if (isset($_FILES['newsroom_banner_1'])  && $_FILES['newsroom_banner_1']['size'] != 0) {
        $filename = time() . '_' . $_FILES['newsroom_banner_1']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["newsroom_banner_1"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $newsroom_banner_1_image = $filepath;

        $newsroom_banner_1->image = $newsroom_banner_1_image;
        $newsroom_banner_1->save();
      }
    } else {
      if (isset($_FILES['newsroom_banner_1'])  && $_FILES['newsroom_banner_1']['size'] != 0) {
        $filename = time() . '_' . $_FILES['newsroom_banner_1']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["newsroom_banner_1"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $newsroom_banner_1_image = $filepath;

        Banner::create([
          'location' => 'newsroom_banner_1',
          'image' => $newsroom_banner_1_image
        ]);
      }
    }

    // Newsroom banner 2
    if ($newsroom_banner_2) {
      if (isset($_FILES['newsroom_banner_2'])  && $_FILES['newsroom_banner_2']['size'] != 0) {
        $filename = time() . '_' . $_FILES['newsroom_banner_2']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["newsroom_banner_2"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $newsroom_banner_2_image = $filepath;

        $newsroom_banner_2->image = $newsroom_banner_2_image;
        $newsroom_banner_2->save();
      }
    } else {
      if (isset($_FILES['newsroom_banner_2'])  && $_FILES['newsroom_banner_2']['size'] != 0) {
        $filename = time() . '_' . $_FILES['newsroom_banner_2']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["newsroom_banner_2"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $newsroom_banner_2_image = $filepath;

        Banner::create([
          'location' => 'newsroom_banner_2',
          'image' => $newsroom_banner_2_image
        ]);
      }
    }

    // Blog banner 1
    if ($blog_banner_1) {
      if (isset($_FILES['blog_banner_1'])  && $_FILES['blog_banner_1']['size'] != 0) {
        $filename = time() . '_' . $_FILES['blog_banner_1']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["blog_banner_1"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $blog_banner_1_image = $filepath;

        $blog_banner_1->image = $blog_banner_1_image;
        $blog_banner_1->save();
      }
    } else {
      if (isset($_FILES['blog_banner_1'])  && $_FILES['blog_banner_1']['size'] != 0) {
        $filename = time() . '_' . $_FILES['blog_banner_1']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["blog_banner_1"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $blog_banner_1_image = $filepath;

        Banner::create([
          'location' => 'blog_banner_1',
          'image' => $blog_banner_1_image
        ]);
      }
    }

    // Blog banner 2
    if ($blog_banner_2) {
      if (isset($_FILES['blog_banner_2'])  && $_FILES['blog_banner_2']['size'] != 0) {
        $filename = time() . '_' . $_FILES['blog_banner_2']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["blog_banner_2"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $blog_banner_2_image = $filepath;

        $blog_banner_2->image = $blog_banner_2_image;
        $blog_banner_2->save();
      }
    } else {
      if (isset($_FILES['blog_banner_2'])  && $_FILES['blog_banner_2']['size'] != 0) {
        $filename = time() . '_' . $_FILES['blog_banner_2']['name'];
        $location = 'banner-images';
        move_uploaded_file($_FILES["blog_banner_2"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $blog_banner_2_image = $filepath;

        Banner::create([
          'location' => 'blog_banner_2',
          'image' => $blog_banner_2_image
        ]);
      }
    }

    return redirect()->back();
  }
}
