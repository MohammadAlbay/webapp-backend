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
        Schema::create('prepaid_card_movements', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('prepaidcard_id');
            // $table->bigInteger('customer_id')->nullable(true);
            // $table->bigInteger('technicain_id')->nullable(true);
            // $table->bigInteger('employee_id')->nullable(true);
            $table->morphs('owner');
            $table->double('balance');
            $table->timestamps();

            // $table->foreign('prepaidcard_id')->references('id')->on('prepaid_cards')
            //     ->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('customer_id')->references('id')->on('customers')
            //     ->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('technicain_id')->references('id')->on('technicains')
            //     ->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('employee_id')->references('id')->on('employees')
            //     ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepaid_card_movements');
    }
};
