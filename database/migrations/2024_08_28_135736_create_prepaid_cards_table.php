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
        Schema::create('prepaid_cards', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('serial')->unique();
            $table->double('money');
            $table->enum('state', ["Active", "Used", "Cancled"])->default("Active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepaid_cards');
    }
};
