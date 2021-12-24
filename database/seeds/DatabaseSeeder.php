<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RouteKnownTableSeeder::class);
        $this->call(CustomerGroupTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(StockBrokerTableSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ConsultingSeeder::class);
        $this->call(ContentHomeSeeder::class);
        $this->call(VisitorReviewSeeder::class);
        
    }
}
