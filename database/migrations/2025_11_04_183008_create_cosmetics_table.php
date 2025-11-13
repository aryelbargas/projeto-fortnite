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
        Schema::create('cosmetics', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("store_id")->unique();
            $table->string("image");
            $table->date("added");
            $table->integer("price")->nullable();
            $table->integer("final_price")->nullable();
            $table->string("rarity");
            $table->string("type");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosmetics');
    }
};
