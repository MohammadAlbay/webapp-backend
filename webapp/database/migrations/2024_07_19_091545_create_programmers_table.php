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
        Schema::create('programmers', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('fullname');
            $table->string('subname')->nullable(true);
            $table->string('email');
            $table->string('password');
            $table->enum('qualification', ['UN-EDUCATED', 'SELF-EDUCATED', 'PREPARATIVE', 'SECONDARY', 'BACHELOR', 'MASTER', 'DOCTOR', 'PROFESSOR']);
            $table->string('studied_at');
            $table->string('profile')->nullable(true);
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmers');
    }
};
