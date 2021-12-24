<?php

use Illuminate\Database\Seeder;
use App\Models\Routeknown;

class RouteKnownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('routeknowns')->delete();
        $json = File::get("database/data/routesknown.json");
        $routes = json_decode($json);
  
        foreach ($routes as $key => $value) {
            Routeknown::create([
                "routeName" => $value->routeName,
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
