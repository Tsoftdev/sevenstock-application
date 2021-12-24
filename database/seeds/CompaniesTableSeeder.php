<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();
        $json = File::get("database/data/companies.json");
        $companies = json_decode($json);
  
        foreach ($companies as $key => $value) {
            Company::create([
                "companyName" => $value->companyName,
                "ownerName" => $value->ownerName,
                "consultdate" => $value->consultdate,
                "reviewdate" => $value->reviewdate,
                "enddate" => $value->enddate,
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
