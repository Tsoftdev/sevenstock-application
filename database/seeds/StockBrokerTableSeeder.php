<?php

use Illuminate\Database\Seeder;
use App\Models\Stockbroker;
class StockBrokerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stockbrokers')->delete();
        $json = File::get("database/data/brokers.json");
        $stockbrokers = json_decode($json);
  
        foreach ($stockbrokers as $key => $value) {
            Stockbroker::create([
                "brokerName" => $value->brokerName,
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
