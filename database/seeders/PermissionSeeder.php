<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function allPermissions()  {
        return [
            [// id:1
                "name" => "Add Employee", "state" => "Active"
            ],
            [// id:2
                "name" => "Edit Employee", "state" => "Active"
            ],
            [ // id:3
                "name" => "Delete Employee", "state" => "Active"
            ],
            [ // id: 4
                "name" => "View Reports", "state" => "Active"
            ]
        ];
    } 
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->allPermissions() as $permission) {
            Permission::create([
                "name" => $permission["name"],
                "state" =>  $permission["state"]
            ]);
        }
    }
}
