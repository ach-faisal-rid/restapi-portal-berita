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
        Schema::create('social_media_folowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('followee_id');

            $table->foreign('follower_id')->references('id')->on('users');
            $table->foreign('followee_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_folowers');
    }
};
