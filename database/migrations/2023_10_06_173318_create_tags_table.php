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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('tag_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->string('locale')->index(); //Language, for example 'hr' or 'en'

            $table->string('title');

            $table->unique(['tag_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tag_translations');
    }
};
