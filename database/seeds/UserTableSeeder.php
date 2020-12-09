<?php


use App\Entities\User;
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
        factory(User::class, 50)->create();

        //User::truncate();

        $admin = new User();

        $admin->first_name = 'Juan';
        $admin->last_name = 'Colorado';
        $admin->email = 'juan2@merca.com';
        $admin->role = 'Administrador';
        $admin->password = bcrypt('12341234');

        $admin->save();

        $client = new User();

        $client->first_name = 'Juan Cliente';
        $client->last_name = 'Colorado';
        $client->email = 'juan@merca.com';
        $client->role = 'Cliente';
        $client->password = bcrypt('12341234');

        $client->save();
    }
}
