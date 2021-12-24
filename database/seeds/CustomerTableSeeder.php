<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();
        $json = File::get("database/data/customers.json");
        $customers = json_decode($json);
  
        foreach ($customers as $key => $value) {
            Customer::create([
                "name" => $value->name,
                "email" => $value->email,
                "age" => $value->age,
                "address" => $value->address,
                "gender" => $value->gender,
                "city_id" => $value->city_id,
                "phonenumber1" => $value->phonenumber1,
                "phonenumber2" => $value->phonenumber2,
                "customerGroupID" => $value->customerGroupID,
                "stockBroker" => $value->stockBroker,
                "AccountNumber" => $value->AccountNumber,
                "routesOfKnownID" => $value->routesOfKnownID,
                "createdBy" => $value->createdBy,
                "updatedBy" => $value->updatedBy,
                "isActive" => $value->isActive,
                "isDelete" => $value->isDelete,
                "date"=> $value->date,
                "isApproved" => $value->isApproved,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
            ]);
        }
    }
}
