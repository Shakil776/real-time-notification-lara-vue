<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Permission List as array
        $permissions = [
            [
                'group_name'  => 'Dashboard',
                'permissions' => [
                    // dashboard permissions
                    'Dashboard.View'
                ],
            ],
            [
                'group_name'  => 'Role',
                'permissions' => [
                    // role Permissions
                    'Role.Create',
                    'Role.View',
                    'Role.Edit',
                    'Role.Delete'
                ],
            ],
            [
                'group_name'  => 'User',
                'permissions' => [
                    // user Permissions
                    'User.Create',
                    'User.View',
                    'User.Edit',
                    'User.Delete'
                ],
            ],
            [
                'group_name'  => 'Department',
                'permissions' => [
                    // Department permissions
                    'Department.Create',
                    'Department.View',
                    'Department.Edit',
                    'Department.Delete'
                ],
            ],
            [
                'group_name'  => 'TimeTable',
                'permissions' => [
                    // TimeTable permissions
                    'TimeTable.Create',
                    'TimeTable.View',
                    'TimeTable.Edit',
                    'TimeTable.Delete'
                ],
            ],
            [
                'group_name'  => 'Shift',
                'permissions' => [
                    // Shift permissions
                    'Shift.Create',
                    'Shift.View',
                    'Shift.Edit',
                    'Shift.Delete'
                ],
            ],
            [
                'group_name'  => 'Employee',
                'permissions' => [
                    // Employee permissions
                    'Employee.Create',
                    'Employee.View',
                    'Employee.Edit',
                    'Employee.Delete'
                ],
            ],
            [
                'group_name'  => 'AttendanceReport',
                'permissions' => [
                    // attendance report permissions
                    'AttendanceReport.View'
                ],
            ],
        ];


        // Create Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::updateOrCreate(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
            }
        }

    }
}
