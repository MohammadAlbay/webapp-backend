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
        Schema::create('skill_jobs', function (Blueprint $table) {
            $table->bigInteger('ad_id');
            $table->string('skill_name');
            $table->timestamps();

            $table->foreign('ad_id')->references('id')->on('advertisements');
            $table->foreign('skill_name')->references('name')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_jobs');
    }
};
