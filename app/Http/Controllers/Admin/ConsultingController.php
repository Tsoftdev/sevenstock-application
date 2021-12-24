<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Consulting;
use App\Models\ConsultingAttachment;
use App\Models\ConsultingEVS;
use App\Models\ConsultingHighlight;
use App\Models\ConsultingNewsVideos;
use App\Models\ConsultingQA;
use App\Models\ConsultingShareholders;
use App\Models\NewsTags;
use App\Models\VideoTags;
use Illuminate\Support\Facades\Session;

class ConsultingController extends Controller
{

  /**
   * Index
   */
  public function index($id)
  {

    $companies = Company::all();

    // News tags
    $news_tags = NewsTags::all();

    // Video tags
    $video_tags = VideoTags::all();

    $consulting = null;
    $consulting_news_ids = null;
    $consulting_videos_ids = null;

    if ($id != 0) {
      $consulting = Consulting::where('company_id', $id)->first();

      if ($consulting) {
        $consulting_news = $consulting->news_videos->where('type', 'news');
        $consulting_videos = $consulting->news_videos->where('type', 'video');

        // news ids
        $news_ids = [];
        foreach ($consulting_news as $news) {
          $news_ids[] = $news->nv_id;
        }
        $consulting_news_ids = implode(",", $news_ids);

        // videos ids
        $videos_ids = [];
        foreach ($consulting_videos as $video) {
          $videos_ids[] = $video->nv_id;
        }
        $consulting_videos_ids = implode(",", $videos_ids);
      }
    }

    return view('admin.change-content.consulting', [
      'selected_company' => $id,
      'companies' => $companies,
      'consulting' => $consulting,
      'news_tags' => $news_tags,
      'video_tags' => $video_tags,
      'consulting_news_ids' => $consulting_news_ids,
      'consulting_videos_ids' => $consulting_videos_ids,
    ]);
  }

  /**
   * Save
   */
  public function save($id)
  {

    if ($id == 0) {

      Session::flash('type', 'error');
      Session::flash('message', 'Please select company.');
      return redirect()->back();
    } else {

      $consulting_data = $_POST;
      $consulting_data['company_id'] = $id;

      if (!isset($_POST['show_red_dot_1'])) {
        $consulting_data['show_red_dot_1'] = 0;
      }
      if (!isset($_POST['show_red_dot_2'])) {
        $consulting_data['show_red_dot_2'] = 0;
      }
      if (!isset($_POST['show_red_dot_3'])) {
        $consulting_data['show_red_dot_3'] = 0;
      }
      if (!isset($_POST['show_red_dot_4'])) {
        $consulting_data['show_red_dot_4'] = 0;
      }

      /** IMAGES */
      // Icon
      if (isset($_FILES['icon']) && $_FILES['icon']['size'] != 0) {
        $filename = time() . '_' . $_FILES['icon']['name'];
        $location = 'consulting-images';
        move_uploaded_file($_FILES["icon"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $consulting_data['icon'] = $filepath;
      }

      // Icon inner
      if (isset($_FILES['icon_inner'])  && $_FILES['icon_inner']['size'] != 0) {
        $filename = time() . '_' . $_FILES['icon_inner']['name'];
        $location = 'consulting-images';
        move_uploaded_file($_FILES["icon_inner"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $consulting_data['icon_inner'] = $filepath;
      }

      // Background image
      if (isset($_FILES['background_image'])  && $_FILES['background_image']['size'] != 0) {
        $filename = time() . '_' . $_FILES['background_image']['name'];
        $location = 'consulting-images';
        move_uploaded_file($_FILES["background_image"]["tmp_name"], $location . '/' . $filename);
        $filepath = url($location . '/' . $filename);
        $consulting_data['background_image'] = $filepath;
      }
      /** IMAGES */


      $consulting = Consulting::where('company_id', '=',  $id)->first();

      if ($consulting == null) {
        $consulting = Consulting::create($consulting_data);
      } else {
        $consulting->fill($consulting_data);
        $consulting->save();
      }

      // Highlight Content
      if (isset($consulting_data['highlight_content'])) {

        // Delete record
        ConsultingHighlight::where('consulting_id', '=', $consulting->id)->delete();

        foreach ($consulting_data['highlight_content'] as $content) {
          ConsultingHighlight::create([
            'consulting_id' => $consulting->id,
            'content' => $content
          ]);
        }
      }


      // Shareholders
      if (isset($consulting_data['shareholders'])) {

        // Delete record
        ConsultingShareholders::where('consulting_id', '=', $consulting->id)->delete();

        foreach ($consulting_data['shareholders'] as $shareholder) {
          ConsultingShareholders::create([
            'consulting_id' => $consulting->id,
            'ceo' => $shareholder['ceo'],
            'percent' => $shareholder['percent'],
          ]);
        }
      }


      // Attachment
      if (isset($_FILES['attachment'])) {

        // Keep the existing attachments and delete deleted ones only
        $keep_attachments = array_filter($_POST['attachment_id'], function ($var) {
          return $var != '';
        });
        ConsultingAttachment::whereNotIn('id', $keep_attachments)->delete();

        foreach ($_FILES['attachment']['name'] as $key => $attachment) {
          if ($_POST['attachment_id'][$key] == 0) {
            if ($_FILES['attachment']['size'][$key] > 0) {
              $filename = time() . '_' . $_FILES['attachment']['name'][$key];
              $location = 'consulting-images';
              move_uploaded_file($_FILES["attachment"]["tmp_name"][$key], $location . '/' . $filename);
              $filepath = url($location . '/' . $filename);
              ConsultingAttachment::create([
                'consulting_id' => $consulting->id,
                'name' => $filename,
                'attachment' => $filepath
              ]);
            }
          }
        }
      }


      // QA
      if (isset($consulting_data['qa'])) {

        // Delete record
        ConsultingQA::where('consulting_id', '=', $consulting->id)->delete();

        foreach ($consulting_data['qa'] as $qa) {
          ConsultingQA::create([
            'consulting_id' => $consulting->id,
            'question' => $qa['question'],
            'answer' => $qa['answer'],
          ]);
        }
      }


      // EVS
      if (isset($consulting_data['evs'])) {

        // Delete record
        ConsultingEVS::where('consulting_id', '=', $consulting->id)->delete();

        foreach ($consulting_data['evs'] as $evs) {
          ConsultingEVS::create([
            'consulting_id' => $consulting->id,
            'title' => $evs['title'],
            'date' => $evs['date'],
          ]);
        }
      }


      // News/Videos
      if (isset($consulting_data['news_videos'])) {

        // Delete record
        ConsultingNewsVideos::where('consulting_id', '=', $consulting->id)->delete();

        foreach ($consulting_data['news_videos'] as $nv) {

          $nv_arr = explode(",", $nv);

          ConsultingNewsVideos::create([
            'consulting_id' => $consulting->id,
            'nv_id' => $nv_arr[1],
            'type' => $nv_arr[0],
          ]);
        }
      }


      Session::flash('type', 'success');
      Session::flash('message', 'Consulting updated successfully.');
      return redirect()->back();
    }
  }


  /**
   * Delete media
   */
  public function delete_media()
  {
    // $consulting_id = $_POST['consulting_id'];
    // $media_field = $_POST['media_field'];

    // return response()->json([
    //   'type' => 'success',
    //   'message' => $media_field . ' has been cleared from consulting id: ' . $consulting_id,
    // ]);

    echo 'test';
  }
}
