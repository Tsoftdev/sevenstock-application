<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('role_user')->delete();
        DB::table('roles')->delete();
        DB::table('permission_role')->delete();
        $json = File::get("database/data/users.json");
        $users = json_decode($json);
  
        foreach ($users as $key => $value) {
            User::create([
                "name" => $value->name,
                "email" => $value->email,
                "password" => $value->password,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                "isActive" => $value->isActive,
                "isDelete" => $value->isDelete,
            ]);
        }

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'superadmin', 'display_name' => 'Super Admin', 'description' => 'Super Admin User', 'created_at' => '2021-10-08 00:00:00','updated_at' => '2021-10-08 00:00:00'],
            ['id' => 2, 'name' => 'saleadmin', 'display_name' => 'Sale Admin', 'description' => 'Sale Admin', 'created_at' => '2021-10-08 00:10:00','updated_at' => '2021-10-08 00:10:00'],
        ]);

        DB::table('role_user')->insert([
            ['user_id' => 1, 'role_id' => '1'],
        ]);

        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $key => $value) {
            $permissions_data[] = [
                'permission_id' => $value->id,
                'role_id'       => '1'
            ];
        }

        DB::table('permission_role')->insert($permissions_data);

        
    }
}
