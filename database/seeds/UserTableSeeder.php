<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $admin = new User();

        $admin->name = 'Juan';
        $admin->email = 'juan2@merca.com';
        $admin->role = 'Administrador';
        $admin->password = bcrypt('12341234');

        $admin->save();

        $user = new User();
        $user->name = 'Juan';
        $user->email = 'juan3@merca.com';
        $user->password = bcrypt('12341234');
        $user->save();
    }
}
