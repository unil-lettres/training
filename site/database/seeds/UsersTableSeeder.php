<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        DB::table('users')->insert([[
          'id' => 1,
          'name' => 'First user',
          'email' => 'user@example.com',
          'password' => bcrypt('password'),
          'remember_token' => Str::random(10),
          'created_at' => $now,
          'updated_at' => $now,
        ]]);

        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'backpack']);
        $notificationRole = Role::create(['name' => 'Notification', 'guard_name' => 'backpack']);

        DB::table('model_has_roles')->insert([
          'role_id' => $adminRole->id,
          'model_type' => 'App\Models\BackpackUser',
          'model_id' => 1
        ]);

        DB::table('model_has_roles')->insert([
          'role_id' => $notificationRole->id,
          'model_type' => 'App\Models\BackpackUser',
          'model_id' => 1
        ]);
    }
}
