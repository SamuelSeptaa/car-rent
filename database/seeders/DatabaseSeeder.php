<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $path = base_path() . '/database/seeders/data.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        // // \App\Models\User::factory(10)->create();
        // $admin = User::create([
        //     'name' => 'uadmin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);

        // $adminRole = Role::create([
        //     'name'          => 'Admin',
        //     'guard_name'    => 'web'
        // ]);

        // $admin->assignRole('Admin');

        // $Permission = Permission::create(['name' => 'view side_bar_menus']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'create side_bar_menus']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'detail side_bar_menus']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'update side_bar_menus']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'delete side_bar_menus']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'view users']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'create users']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'detail users']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'update users']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'delete users']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'view roles']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'create roles']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'detail roles']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'update roles']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'delete roles']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'view permissions']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'create permissions']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'detail permissions']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'update permissions']);
        // $adminRole->givePermissionTo($Permission);

        // $Permission = Permission::create(['name' => 'delete permissions']);
        // $adminRole->givePermissionTo($Permission);
    }
}
