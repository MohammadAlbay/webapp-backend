<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->enum('state', ["Active", "Inactive"])->default("Active");
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });
    }

    /* 
        Employee:
            1   Admin Mohammad  admin@company.com   Admin
            2   Ahmed           ahemd@gmail.com     Data inseertion
            ...
            ...


        Permission:
            1   Add Employee
            2   Edit Employee
            ..
            ..
            100 View Transactions
            101 View technicain reports
            102 View Customer reports

        Roles:
            1   Admin
            2   Data inseertion
            3   Report Viewer
            4   HR
            5 New Role

        RolePermissions:
            ID  R_ID   P_ID
            1    1      1
            2    1      2
            3    1      3
            4    1      4
            5    2      1
            6    2      2
            7    3      101
            8    3      102

    */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
