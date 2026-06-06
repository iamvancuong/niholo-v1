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
        Schema::create('kanjis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('character')->unique();
            $table->string('sino_vietnamese'); // Âm Hán Việt
            $table->string('meaning'); // Nghĩa tiếng Việt
            $table->json('onyomi')->nullable(); // Mảng âm On
            $table->json('kunyomi')->nullable(); // Mảng âm Kun
            $table->integer('stroke_count'); // Số nét
            $table->string('jlpt_level')->default('N5'); // N5, N4...
            $table->text('mnemonic')->nullable(); // Gợi ý cách nhớ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanjis');
    }
};
