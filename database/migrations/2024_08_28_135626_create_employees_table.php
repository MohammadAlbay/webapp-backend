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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('state', ["Active", "Inactive"])->default("Active");
            $table->string('profile')->nullable(true);
            $table->string('phone');
            $table->string('address');
            $table->enum('gender', ["Male", "Female"]);
            $table->bigInteger('role_id');
            $table->timestamps();
            $table->rememberToken();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
