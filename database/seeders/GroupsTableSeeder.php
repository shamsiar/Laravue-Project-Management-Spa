<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('groups')->truncate();

        DB::table('groups')->insert(
            [
                [
                    'title' => 'Group 1',
                ],
                [
                    'title' => 'Group 2',
                ],
            ]
        );
    }
}
