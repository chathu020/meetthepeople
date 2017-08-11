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
            'username' => "admin",
            'name' => "Admin",
            'email' => 'test@test.com',
            'password' => bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'username' => "counter",
            'name' => "Counter A",
            'email' => 'testcounter@test.com',
            'password' => bcrypt('counter'),
        ]);

        DB::table('users')->insert([
            'username' => "writer",
            'name' => "Writer",
            'email' => 'writer@test.com',
            'password' => bcrypt('writer'),
        ]);

        DB::table('users')->insert([
            'username' => "mpuser",
            'name' => "MP",
            'email' => 'mpuser@test.com',
            'password' => bcrypt('mpuser'),
        ]);
    }
}
