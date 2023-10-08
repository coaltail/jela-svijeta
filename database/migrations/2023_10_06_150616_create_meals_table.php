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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');
            $table->softDeletes(); //deleted_at
            $table->timestamps(); //updated_at, created_at
        });

        Schema::create('meal_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->string('locale')->index(); //Language, for example 'hr' or 'en'

            $table->string('title');
            $table->string('description');
            $table->unique(['meal_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
