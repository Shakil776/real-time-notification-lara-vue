<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::where('email', 'superadmin@gmail.com')->first();

        if (is_null($superadmin)) {
            $user = new User();
            $user->name = "Super Admin";
            $user->email = "superadmin@gmail.com";
            $user->mobile = "01738620241";
            $user->password = Hash::make('Superadmin@123');
            $user->save();
        }

        $role = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
