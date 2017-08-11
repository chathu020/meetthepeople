<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	[
        		'name' => 'admin',
        		'display_name' => 'Admin',
        		'description' => 'Administrator'
        	],
        	[
        		'name' => 'writer',
        		'display_name' => 'Writer',
        		'description' => 'System front officer and cas writer'
        	],
        	[
        		'name' => 'mp',
        		'display_name' => 'MP',
        		'description' => 'MP'
        	],
            [
                'name' => 'counterA',
                'display_name' => 'Counter A officer',
                'description' => 'Counter A officer'
            ]
        ];

        foreach ($roles as $key => $value) {
        	Role::create($value);
        }
        $role = Role::where('name', '=', 'admin')->first();
        $user = User::where('username', '=', 'admin')->first();

        // role attach alias
        $user->attachRole($role); 
        $role = Role::where('name', '=', 'writer')->first();
        $user = User::where('username', '=', 'writer')->first();

        // role attach alias
        $user->attachRole($role); 
        $role = Role::where('name', '=', 'counterA')->first();
        $user = User::where('username', '=', 'counter')->first();

        // role attach alias
        $user->attachRole($role); 
    }
}