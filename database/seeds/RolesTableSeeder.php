<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $admin = Role::create(['name' => 'super-admin']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'remove users']);
        
        $admin->givePermissionTo(Permission::all());
        $admin_user = App\User::find(1);
        $admin_user->assignRole('super-admin');
    }
}
