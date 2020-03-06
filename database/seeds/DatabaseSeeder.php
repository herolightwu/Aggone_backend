<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
//         $this->call(TableSportsSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(TableUserGroupsSeeder::class);
        Model::reguard();
    }
}
