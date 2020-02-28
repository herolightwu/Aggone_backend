<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableUserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            'title' => 'Player',
            'description' => "Player Group",
        ]);
        DB::table('user_groups')->insert([
            'title' => 'Coach',
            'description' => "Coach Group",
        ]);
        DB::table('user_groups')->insert([
            'title' => 'Team/Club',
            'description' => "Team/Club Group",
        ]);
        DB::table('user_groups')->insert([
            'title' => 'Agent',
            'description' => "Agent Group",
        ]);
        DB::table('user_groups')->insert([
            'title' => 'Staff',
            'description' => "Staff Group",
        ]);
        DB::table('user_groups')->insert([
            'title' => 'Company',
            'description' => "Company Group",
        ]);
    }
}
