<?php
$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

$schemas = [
    'create_courses_table' => <<<PHP
            \$table->id();
            \$table->string('name');
            \$table->text('description')->nullable();
            \$table->string('level'); // N5, N4
            \$table->string('thumbnail_url')->nullable();
            \$table->boolean('is_published')->default(false);
            \$table->timestamps();
PHP,
    'create_lessons_table' => <<<PHP
            \$table->id();
            \$table->foreignId('course_id')->constrained()->cascadeOnDelete();
            \$table->string('title');
            \$table->string('jf_standard_code')->nullable(); // VD: A1-1
            \$table->integer('order_index');
            \$table->text('grammar_focus')->nullable();
            \$table->boolean('is_published')->default(false);
            \$table->timestamps();
PHP,
    'create_grammar_points_table' => <<<PHP
            \$table->id();
            \$table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            \$table->string('title'); // VD: は vs が
            \$table->text('cure_dolly_explanation')->nullable();
            \$table->string('visual_model_url')->nullable();
            \$table->timestamps();
PHP,
    'create_example_sentences_table' => <<<PHP
            \$table->id();
            \$table->foreignId('grammar_point_id')->nullable()->constrained()->cascadeOnDelete();
            \$table->foreignId('card_id')->nullable()->constrained()->cascadeOnDelete();
            \$table->text('japanese');
            \$table->text('english')->nullable();
            \$table->text('vietnamese');
            \$table->json('furigana_json')->nullable();
            \$table->string('audio_url')->nullable();
            \$table->boolean('is_real_voice')->default(false);
            \$table->timestamps();
PHP,
    'create_drag_drop_puzzles_table' => <<<PHP
            \$table->id();
            \$table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            \$table->json('blocks_json'); // Các mảnh ghép
            \$table->json('correct_order'); // Thứ tự đúng
            \$table->text('translation');
            \$table->timestamps();
PHP,
    'create_cards_table' => <<<PHP
            \$table->id();
            \$table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            \$table->enum('type', ['vocabulary', 'kanji', 'grammar']);
            \$table->string('front_text');
            \$table->string('back_text');
            \$table->string('reading')->nullable(); // Hiragana/Katakana
            \$table->string('audio_url')->nullable();
            \$table->text('mnemonic')->nullable(); // Mẹo nhớ
            \$table->timestamps();
PHP,
    'create_user_reviews_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('card_id')->constrained()->cascadeOnDelete();
            \$table->integer('state')->default(0); // 0=New, 1=Learning, 2=Review, 3=Relearning
            \$table->double('stability');
            \$table->double('difficulty');
            \$table->double('elapsed_days');
            \$table->double('scheduled_days');
            \$table->integer('reps')->default(0);
            \$table->integer('lapses')->default(0);
            \$table->boolean('is_leech')->default(false);
            \$table->boolean('is_suspended')->default(false);
            \$table->timestamp('last_review_at')->nullable();
            \$table->timestamp('next_review_at')->nullable();
            \$table->timestamps();
PHP,
    'create_user_stats_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->integer('total_xp')->default(0);
            \$table->integer('current_streak')->default(0);
            \$table->integer('longest_streak')->default(0);
            \$table->integer('streak_freezes')->default(0);
            \$table->timestamp('last_learned_at')->nullable();
            \$table->string('current_league')->default('bronze');
            \$table->timestamps();
PHP,
    'create_learning_sessions_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->integer('duration_minutes')->default(0);
            \$table->boolean('is_verified')->default(false); // Chống AFK
            \$table->timestamp('started_at');
            \$table->timestamp('ended_at')->nullable();
            \$table->timestamps();
PHP,
    'create_quests_table' => <<<PHP
            \$table->id();
            \$table->string('title');
            \$table->string('description');
            \$table->enum('type', ['daily', 'weekly']);
            \$table->integer('target_amount'); // VD: 50 thẻ
            \$table->integer('xp_reward');
            \$table->timestamps();
PHP,
    'create_user_quests_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('quest_id')->constrained()->cascadeOnDelete();
            \$table->integer('progress')->default(0);
            \$table->boolean('is_completed')->default(false);
            \$table->boolean('is_claimed')->default(false);
            \$table->timestamp('expires_at')->nullable();
            \$table->timestamps();
PHP,
    'create_manual_overrides_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('card_id')->constrained()->cascadeOnDelete();
            \$table->enum('action', ['mark_known', 'unleech', 'suspend']);
            \$table->timestamps();
PHP,
    'create_subscriptions_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('stripe_id')->nullable();
            \$table->string('stripe_status')->nullable();
            \$table->string('stripe_price')->nullable();
            \$table->integer('quantity')->nullable();
            \$table->timestamp('trial_ends_at')->nullable();
            \$table->timestamp('ends_at')->nullable();
            \$table->timestamps();
PHP,
    'create_payments_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('gateway'); // vnpay, momo, stripe
            \$table->string('transaction_id')->unique();
            \$table->decimal('amount', 10, 2);
            \$table->string('currency')->default('VND');
            \$table->enum('status', ['pending', 'success', 'failed']);
            \$table->json('payload_json')->nullable();
            \$table->timestamps();
PHP,
    '0001_01_01_000000_create_users_table' => <<<PHP
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->boolean('is_premium')->default(false);
            \$table->rememberToken();
            \$table->timestamps();
PHP,
];

foreach ($files as $file) {
    if (strpos($file, '.php') === false) continue;
    
    foreach ($schemas as $key => $schema) {
        if (strpos($file, $key) !== false) {
            $path = $dir . $file;
            $content = file_get_contents($path);
            
            // Tìm block `Schema::create` và thay thế ruột của nó.
            $pattern = '/(Schema::create\([\'"].*?[\'"], function \(Blueprint \$table\) \{)(.*?)(\}\);)/s';
            $replacement = "$1\n$schema\n        $3";
            
            $newContent = preg_replace($pattern, $replacement, $content);
            file_put_contents($path, $newContent);
            echo "Updated $file\n";
        }
    }
}
