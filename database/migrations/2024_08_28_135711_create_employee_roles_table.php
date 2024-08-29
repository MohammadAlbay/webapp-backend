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
        Schema::create('employee_roles', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('role_id');
            $table->bigInteger('employee_id');
            $table->enum('state', ["Active", "Inactive"])->default("Active");
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_roles');
    }
};
