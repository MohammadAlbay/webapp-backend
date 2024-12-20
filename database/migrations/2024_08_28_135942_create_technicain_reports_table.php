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
        Schema::create('technicain_reports', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('customer_id');
            $table->bigInteger('technicain_id');
            $table->enum('state', ['Pending', 'Done'])->default('Pending');
            $table->string('description');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('technicain_id')->references('id')->on('technicains');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicain_reports');
    }
};
