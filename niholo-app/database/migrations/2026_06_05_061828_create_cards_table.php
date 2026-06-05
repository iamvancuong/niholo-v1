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
            $table->text('mnemonic')->nullable(); // Mẹo nhớ
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
