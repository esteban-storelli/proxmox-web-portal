<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'user', 'email' => 'user@user.com', 'password' => bcrypt('user'), 'role' => 'user'],
            ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin'), 'role' => 'admin'],
        ]);
    }
}
