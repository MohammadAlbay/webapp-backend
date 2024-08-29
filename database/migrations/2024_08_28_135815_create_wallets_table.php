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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            // $table->bigInteger('customer_id')->nullable(true);
            // $table->bigInteger('technicain_id')->nullable(true);
            // $table->bigInteger('employee_id')->nullable(true);
            // $table->double('money');
            $table->morphs('owner'); // This will create owner_id and owner_type columns
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('wallets');
    }
};
