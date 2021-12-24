<?php

namespace App\Http\Start;

use View;
use Session;
use DateTime;

class Helpers {
    public function flash_message($class, $message) {
		Session::flash('alert-class', 'alert-'.$class);
	    Session::flash('message', $message);
	}

	public function formatPhoneNum($phone){
// 		$phone = preg_replace("/[^0-9]*/",'',$phone);
// 		if(strlen($phone) != 11) return("");
// 		$sArea = substr($phone,0,3);
// 		$sPrefix = substr($phone,3,4);
// 		$sNumber = substr($phone,7,4);
// 		//$phone = "(".$sArea.") ".$sPrefix."-".$sNumber;
// 		$phone = $sArea."-".$sPrefix."-".$sNumber;
		return($phone);
	}

	// public function validateDate($date, $format = 'Y.m.d')
	// 	{
	// 		$d = DateTime::createFromFormat($format, $date);
	// 		return $d && $d->format($format) === $date;
	// 	}

}