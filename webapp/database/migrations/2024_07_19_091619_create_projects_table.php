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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('programmer_id');
            $table->string('title');
            $table->string('description');
            $table->string('github_link')->nullable(true);
            $table->timestamps();

            $table->foreign('programmer_id')->references('id')->on('programmers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
