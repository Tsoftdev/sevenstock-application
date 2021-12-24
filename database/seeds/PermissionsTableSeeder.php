<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('permissions')->insert([
            [
                'name' => 'manage_admin', 
                'display_name' => 'Manage Admin',
                'description' => 'Manage Admin'
            ],
            [
                'name' => 'manage_schedule', 
                'display_name' => 'Manage Schedule',
                'description' => 'Manage Schedule'
            ],
            [
                'name' => 'manage_customer', 
                'display_name' => 'Manage Customer',
                'description' => 'Manage Customer'
            ],
            [
                'name' => 'manage_company', 
                'display_name' => 'Manage Company',
                'description' => 'Manage Company'
            ],
            [
                'name' => 'manage_sms', 
                'display_name' => 'Manage SMS',
                'description' => 'Manage SMS'
            ]
        ]);
    }
}
