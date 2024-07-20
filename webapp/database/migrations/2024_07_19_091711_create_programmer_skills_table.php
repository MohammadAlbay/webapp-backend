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
        Schema::create('programmer_skills', function (Blueprint $table) {
            $table->bigInteger('programmer_id');
            $table->string('skill_name');
            $table->timestamps();

            $table->foreign('programmer_id')->references('id')->on('programmers');
            $table->foreign('skill_name')->references('name')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmer_skills');
    }
};
