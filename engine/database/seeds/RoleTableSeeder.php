<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
          'name' => 'Developer User',
          'slug' => 'developer',
          'enabled' => true
        ]);
        DB::table('roles')->insert([
          'name' => 'Administrator',
          'slug' => 'admin',
          'enabled' => true
        ]);
        DB::table('roles')->insert([
          'name' => 'Standard User',
          'slug' => 'standard',
          'enabled' => true
        ]);
    }
}
