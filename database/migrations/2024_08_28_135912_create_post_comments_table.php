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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('post_id');
            $table->morphs('owner'); // This will create owner_id and owner_type columns
            $table->string('comment');
            $table->timestamps();

            //$table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
