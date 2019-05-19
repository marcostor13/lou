<?php

use Illuminate\Database\Seeder;
use Lou\Role;
use Lou\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = "User";
        $user->email = "user@mail.com";
        $user->password = bcrypt('user');
        $user->save();
        $user->roles()->attach($role_user); 

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@mail.com";
        $user->password = bcrypt('admin');
        $user->save();
        $user->roles()->attach($role_admin); 

    }
}
