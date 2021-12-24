<?php

use Illuminate\Database\Seeder;
use App\Models\Customergroup;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customergroups')->delete();
        $json = File::get("database/data/customergroups.json");
        $customergroups = json_decode($json);
  
        foreach ($customergroups as $key => $value) {
            Customergroup::create([
                "groupName" => $value->groupName,
                "createdBy" => $value->createdBy,
                "isActive" => $value->isActive,
                "isDelete" => $value->isDelete,
                "isApproved" => $value->isApproved,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
            ]);
        }
    }
}
