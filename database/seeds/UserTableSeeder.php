<?php


use App\Entities\User;
use App\Constants\UserRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        Role::truncate();
        User::truncate();

        $deleteProductsPermission = Permission::create(['name' => 'Delete products']);
        $viewOrdersPermission = Permission::create(['name' => 'View orders']);

        $adminRole = Role::create(['name' => UserRoles::ADMINISTRATOR]);
        $powerUserRole = Role::create(['name' => UserRoles::POWERUSER]);
        $clientRole = Role::create(['name' => UserRoles::CLIENT]);

        $admin = new User();
        $admin->first_name = 'Admin Mercatodo';
        $admin->last_name = 'Admin';
        $admin->email = 'admin@mercatodo.com';
        $admin->role = UserRoles::ADMINISTRATOR;
        $admin->password = bcrypt('12341234');
        $admin->save();

        $admin->assignRole($adminRole);
        $admin->hasPermissionTo($deleteProductsPermission);
        $admin->hasPermissionTo($viewOrdersPermission);

        $powerUser = new User();
        $powerUser->first_name = 'PowerUser Mercatodo';
        $powerUser->last_name = 'PowerUser';
        $powerUser->email = 'poweruser@mercatodo.com';
        $powerUser->role = UserRoles::POWERUSER;
        $powerUser->password = bcrypt('12341234');
        $powerUser->save();

        $powerUser->assignRole($powerUserRole);

        $client = new User();
        $client->first_name = 'Cliente Mercatodo';
        $client->last_name = 'Cliente';
        $client->email = 'cliente@mercatodo.com';
        $client->role = UserRoles::CLIENT;
        $client->password = bcrypt('12341234');
        $client->save();

        $client->assignRole($clientRole);

        factory(User::class, 50)->create();
    }
}
