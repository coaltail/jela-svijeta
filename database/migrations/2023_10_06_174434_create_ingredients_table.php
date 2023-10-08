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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('ingredients_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('ingredients_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->string('locale')->index(); //Language, for example 'hr' or 'en'

            $table->string('title');

            $table->unique(['ingredients_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('ingredients_translations');
    }
};
