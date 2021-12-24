<?php

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();
        $json = File::get("database/data/cities.json");
        $cities = json_decode($json);
  
        foreach ($cities as $key => $value) {
            City::create([
                "cityName" => $value->cityName,
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
