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
        Schema::create('user_cosmetics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("cosmetic_id");

            $table->unique(["user_id", "cosmetic_id"]);

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("cosmetic_id")->references("id")->on("cosmetics");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cosmetics');
    }
};
