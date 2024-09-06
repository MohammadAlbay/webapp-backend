<?php

namespace Database\Seeders;

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
        Role::create([
            "name" => "Admin"
        ]);
        Role::create([
            "name" => "Dummy role"
        ]);

        RolePermissions::create([
            "role_id" => 1,
            "permission_id" => 1,
            "state" => "Active"
        ]);
        RolePermissions::create([
            "role_id" => 1,
            "permission_id" => 2,
            "state" => "Active"
        ]);
    }
}
