<?php

use App\Models\Stock;
use App\Models\ContactInquiries;
// Total inquiries count
function total_inquiries_count($inquiry_type = null)
{
  if ($inquiry_type == null) {
    $total_inquiries = ContactInquiries::where(['read' => 0])->count();
  } else {
    $total_inquiries = ContactInquiries::where(['inquiry_type' => $inquiry_type, 'read' => 0])->count();
  }
  return $total_inquiries;
}

function getStockCounts($start, $end)
{
  return Stock::select('userId', \DB::raw('SUM(invested) as total_invested'))->whereBetween('invested', [$start * 1000000, $end * 1000000])->groupBy('userId')->get()->count();
}
