<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('users')->insert([
          'name' => 'Einstein',
          'email' => 'einstein@self-ivr.org',
          'password' => bcrypt('self'),
          'role' => 1,
      ]);

      factory(App\User::class, 50)->create();
    }
}
