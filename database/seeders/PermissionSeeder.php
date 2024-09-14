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
            [ // id:4
                "name" => "View Employee", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // 5
                "name" => "Allow Login", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // id: 6
                "name" => "Generate Prepaidcards", "state" => "Active"
            ],
            [ // id: 7
                "name" => "Print Prepaidcards", "state" => "Active"
            ],
            [ // id: 8
                "name" => "View Prepaidcards", "state" => "Active"
            ],
            [ // id: 9
                "name" => "Modify Prepaidcards", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // id: 10
                "name" => "Edit Customer", "state" => "Active"
            ],
            [ // id: 11
                "name" => "View Customer", "state" => "Active"
            ],
            [ // id: 12
                "name" => "Block Customer", "state" => "Active"
            ],
            [ // id: 13
                "name" => "Customer Reports", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // id: 14
                "name" => "Technicain Edit", "state" => "Active"
            ],
            [ // id: 15
                "name" => "Technicain View", "state" => "Active"
            ],
            [ // id: 16
                "name" => "Technicain Block", "state" => "Active"
            ],
            [ // id: 17
                "name" => "Technicain Reports", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // id: 18
                "name" => "Prepaidcards History", "state" => "Active"
            ],
            [ // id: 19
                "name" => "View Transactions", "state" => "Active"
            ],
//--------------------------------------------------------------------
            [ // id: 20
                "name" => "View Role", "state" => "Active"
            ], 
            [ // id: 21
                "name" => "Add Role", "state" => "Active"
            ], 
            [ // id: 22
                "name" => "Edit Role", "state" => "Active"
            ], 
            [ // id: 23
                "name" => "View Permission", "state" => "Active"
            ],
            [ // id: 24
                "name" => "Edit Permission", "state" => "Active"
            ],
            [ // id: 25
                "name" => "Manage Wallets", "state" => "Active"
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
