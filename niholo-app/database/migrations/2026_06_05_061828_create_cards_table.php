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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['vocabulary', 'kanji', 'grammar']);
            $table->string('front_text');
            $table->string('back_text');
            $table->string('reading')->nullable(); // Hiragana/Katakana
            $table->string('audio_url')->nullable();
            $table->string('image_url')->nullable();
            $table->text('mnemonic')->nullable(); // Mẹo nhớ
            
            // Example fields
            $table->string('example_japanese')->nullable();
            $table->string('example_vietnamese')->nullable();
            $table->string('example_audio_url')->nullable();
            $table->json('example_blocks_json')->nullable(); // Các mảnh ghép cho Drag Drop Puzzle
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
