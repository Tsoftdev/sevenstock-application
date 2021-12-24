<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{
	public $customers;

	public function __construct($customers){

		$this->customers = $customers;

	}	

    public function view(): View
    {
        return view('admin.customers.export', [
            'customers' => $this->customers
        ]);
    }
}