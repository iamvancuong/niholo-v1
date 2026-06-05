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
        Schema::create('example_sentences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_point_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('card_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('japanese');
            $table->text('english')->nullable();
            $table->text('vietnamese');
            $table->json('furigana_json')->nullable();
            $table->string('audio_url')->nullable();
            $table->boolean('is_real_voice')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('example_sentences');
    }
};
