<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insertGetId([
            'name' => 'Admin user',
            'email' => 'admin-user@example.com',
            'password' => bcrypt('password'),
            'roles' => json_encode(['admin', 'notification']),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            'name' => 'Second user',
            'email' => 'second-user@example.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
