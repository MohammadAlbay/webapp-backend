<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([ //1
            "name" => "Admin"
        ]);
        Role::create([ //2
            "name" => "Sales"
        ]);
        Role::create([ //3
            "name" => "Social Media"
        ]);

        Role::create([ //4
            "name" => "Operational Services"
        ]);
        Role::create([ //5
            "name" => "Data Insertor"
        ]);

        Role::create([ //6
            "name" => "Report Inspector"
        ]);

        Role::create([ //7
            "name" => "Finance Manager"
        ]);

        Role::create([ //8
            "name" => "System"
        ]);
        $this->addAdminPermissions();
        $this->addFinancePermissions();
        $this->addDataInsertorPermissions();
        $this->addSystemPermissions();
    }

    private function addSystemPermissions() {
        // 
    }
    private function addDataInsertorPermissions() {
        $permissions = [
            Permission::PERMISSION_ADD_EMPLOYEE_ID,
            Permission::PERMISSION_VIEW_EMPLOYEE_ID,
            Permission::PERMISSION_EDIT_EMPLOYEE_ID,
            Permission::PERMISSION_ALLOW_LOGIN_ID
        ];

        foreach($permissions as $p) {
            RolePermissions::create([
                "role_id" => 5,
                "permission_id" => $p,
                "state" => "Active"
            ]);
        }
    }

    private function addFinancePermissions() {
        $permissions = [
            Permission::PERMISSION_GENERATE_PREPAIDCARDS_ID,
            Permission::PERMISSION_VIEW_PREPAIDCARDS_ID,
            Permission::PERMISSION_MODIFY_PREPAIDCARDS_ID,
            Permission::PERMISSION_PREPAIDCARDS_HISTORY_ID,
            Permission::PERMISSION_VIEW_TRANSACTIONS_ID,
            Permission::PERMISSION_MANAGE_WALLETS_ID,
            Permission::PERMISSION_ALLOW_LOGIN_ID
        ];

        foreach($permissions as $p) {
            RolePermissions::create([
                "role_id" => 7,
                "permission_id" => $p,
                "state" => "Active"
            ]);
        }
    }
    private function addAdminPermissions(): void {
        foreach(Permission::all() as $p) {
            RolePermissions::create([
                "role_id" => 1,
                "permission_id" => $p->id,
                "state" => "Active"
            ]);
        }
    }
}
