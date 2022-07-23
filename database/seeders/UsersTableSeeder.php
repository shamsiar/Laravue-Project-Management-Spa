<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'admin@gmail.com')->delete();

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@user.com',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@user.com',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ],
            [
                'name' => 'User3',
                'email' => 'user3@user.com',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ],
            [
                'name' => 'User 4',
                'email' => 'user4@user.com',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ],
        ]);
    }
}
