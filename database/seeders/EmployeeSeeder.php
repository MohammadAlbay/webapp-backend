<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            "fullname" => "Admin Mohammad",
            "email" => "admin@company.com",
            "address" => "Tripoli",
            "password" => "$2y$12$7fOYPG/XB/a5J/Tc.ZeqneqXTsZDGmoEcdd3W7SlTr3FpCiWFFxsS",
            "phone" => "",
            "profile" => "",
            "gender" => "Male",
            "state" => "Active",
            "role_id" => 1,
        ]);

        Employee::create([
            "fullname" => "System",
            "email" => "system@company.com",
            "address" => "Tripoli",
            "password" => "$2y$12$7fOYPG/XB/a5J/Tc.ZeqneqXTsZDGmoEcdd3W7SlTr3FpCiWFFxsS",
            "phone" => "",
            "profile" => "",
            "gender" => "Male",
            "state" => "Active",
            "role_id" => 1,
        ]);
    }
}
