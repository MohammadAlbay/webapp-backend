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
        Schema::create('technicains', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('state', ["Active", "Inactive", "Bloced", "Paused"])->default("Inactive");
            $table->string('profile');
            $table->string('phone');
            $table->string('nationality');
            $table->string('address');
            $table->string('description');
            $table->bigInteger('specialization_id');
            $table->enum('dender', ["Male", "Female"]);
            $table->timestamps();
            $table->rememberToken();

            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicains');
    }
};
