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
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('card_id')->constrained()->cascadeOnDelete();
            $table->integer('state')->default(0); // 0=New, 1=Learning, 2=Review, 3=Relearning
            $table->double('stability');
            $table->double('difficulty');
            $table->double('elapsed_days');
            $table->double('scheduled_days');
            $table->integer('reps')->default(0);
            $table->integer('lapses')->default(0);
            $table->boolean('is_leech')->default(false);
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('last_review_at')->nullable();
            $table->timestamp('next_review_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reviews');
    }
};
