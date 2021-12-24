<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShareholderExport implements FromView
{
	public $shareholders;

	public function __construct($shareholders){

		$this->shareholders = $shareholders;

	}	

    public function view(): View
    {
        return view('admin.shareholder.export', [
            'shareholders' => $this->shareholders
        ]);
    }
}