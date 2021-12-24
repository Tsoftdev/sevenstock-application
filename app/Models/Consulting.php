<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
  // Table name
  protected $table = 'consulting';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'company_id',
    'publish',
    'icon',
    'company_name_kor',
    'company_name_eng',
    'title',
    'industry',
    'enterprise_valuation',
    'expected_growth_rate',
    'background_image',
    'icon_inner',
    'company_name_kor_inner',
    'subtitle',
    'company_video_link',
    'service_video_link',
    'user_review_video_link',
    'industry_inner',
    'market_value',
    'ceo_name',
    'founding_date',
    'capital',
    'total_shares',
    'unified_stocks',
    'keyword',
    'company_website',
    'highlight',
    'problem',
    'suggest_solution',
    'suggest_solution',
    'service_introduction',
    'service_diff_eff',
    'market_analysis',
    'business_status',
    'about_company',
    'ceo',
    'members',
    'before_after_desc',
    'before_consulting',
    'current_value',
    'current_value_date',
    'expectation_growth_rate',
    'show_red_dot_1',
    'red_dot_1_title',
    'red_dot_1_amount',
    'show_red_dot_2',
    'red_dot_2_title',
    'red_dot_2_amount',
    'show_red_dot_3',
    'red_dot_3_title',
    'red_dot_4_amount',
    'show_red_dot_4',
    'red_dot_4_title',
    'red_dot_4_amount',
  ];

  /**
   * Get the highlight content associated with the consulting.
   */
  public function highlight_content()
  {
    return $this->hasMany(ConsultingHighlight::class, 'consulting_id', 'id');
  }

  /**
   * Get the shareholders associated with the consulting.
   */
  public function shareholders()
  {
    return $this->hasMany(ConsultingShareholders::class, 'consulting_id', 'id');
  }

  /**
   * Get the attachments associated with the consulting.
   */
  public function attachment()
  {
    return $this->hasMany(ConsultingAttachment::class, 'consulting_id', 'id');
  }

  /**
   * Get the QAs associated with the consulting.
   */
  public function qa()
  {
    return $this->hasMany(ConsultingQA::class, 'consulting_id', 'id');
  }

  /**
   * Get the EVS associated with the consulting.
   */
  public function evs()
  {
    return $this->hasMany(ConsultingEVS::class, 'consulting_id', 'id');
  }

  /**
   * Get the News/Videos associated with the consulting.
   */
  public function news_videos()
  {
    return $this->hasMany(ConsultingNewsVideos::class, 'consulting_id', 'id');
  }
}
