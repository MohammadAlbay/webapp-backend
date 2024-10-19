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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('wallet_in_id');
            $table->bigInteger('wallet_out_id');
            $table->decimal('money', 15, 2)->default(0);
            $table->string('description', 2000)->nullable(true);
            $table->enum('type', ['Sub', 'Other'])->default('Sub');
            $table->date("due");
            $table->timestamps();

            $table->foreign('wallet_in_id')->references('id')->on('wallets')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('wallet_out_id')->references('id')->on('wallets')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
