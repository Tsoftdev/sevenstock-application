<?php

namespace App\Imports;

use Auth;
use App\Models\City;
use App\Models\Level;
use App\Models\Customer;
use App\Models\Routeknown;
use App\Models\Stockbroker;
use App\Models\Customergroup;
use App\Models\CustomerStatus;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        foreach ($rows as $row){
 
            if(is_numeric($row[0])){
                $InvDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]); 
                $first_visiting_date        = $InvDate->format('Y-m-d');
            }else{
                $first_visiting_date        = $row[0] ? date('Y-m-d', strtotime($row[0])) : null;
            }
          
            $city           = City::where('cityName', $row[5])->first();
            $experience     = Level::where('levelName', $row[11])->first();
            $customerStatus = CustomerStatus::where('statusName', $row[12])->first();
            $routeknown     = Routeknown::where('routeName', $row[16])->first();

            if(!$city && $row[5] !=''){
                $city               = new City;
                $city->cityName     = $row[5];
                $city->createdBy    = 1;
                $city->save();
            }
            if(!$experience && $row[11] !=''){
                $experience              = new Level;
                $experience->levelName   = $row[11];
                $experience->isActive    = "Y";
                $experience->createdBy   = Auth::guard('admin')->user()->id;
                $experience->save();
            }
            if(!$customerStatus && $row[12] !=''){
                $customerStatus             = new CustomerStatus;
                $customerStatus->statusName = ucfirst($row[12]);
                $customerStatus->save();
            }
            if(!$routeknown && $row[16] !=''){
                $routeknown              = new Routeknown;
                $routeknown->routeName   = $row[16];
                $routeknown->createdBy   = 1;
                $routeknown->save();
            }

            

            $alreadyData                = Customer::where('phonenumber1', $row[2])->first();
            $customer                   = $alreadyData ? $alreadyData : new Customer;
            $customer->name             = $row[1] ? $row[1] : 'no name';
    		$customer->phonenumber1     = $row[2];
            $customer->phonenumber2     = $row[3];
			$customer->email            = $row[4];
			$customer->city_id          = $city ? $city->id : NULL;
            $customer->address          = $row[6];
            $customer->age              = $row[7];
            $customer->finance          = $row[8];
            $customer->stock_investment_experience  = $row[9];
            $customer->return_on_investment         = $row[10];
            $customer->level                        = $experience ? $experience->id : NULL;
            $customer->status_id                    = $customerStatus ? $customerStatus->id : NULL;
            $customer->first_visited_date           = $first_visiting_date;
            $customer->profit_lose                  = $row[13];
            $customer->investment_path              = $row[14];
            $customer->investable_liquid_funds      = $row[15];
			$customer->routesOfKnownID  = $routeknown ? $routeknown->id : NULL;
            $customer->note             = $row[17];
            $customer->createdBy        = Auth::guard('admin')->user()->id;;
            $customer->updatedBy        = Auth::guard('admin')->user()->id;;
			$customer->save();
		}
	}
}
