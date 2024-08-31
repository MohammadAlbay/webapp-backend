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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('state', ["Active", "Inactive", "Bloced"])->default("Active");
            $table->string('profile')->nullable(true);
            $table->string('phone');
            $table->string('address');
            $table->enum('gender', ["Male", "Female"]);
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
