# Niholo V1 — Kiến trúc Hệ thống Tối ưu (North Star Document)

> **Tạo lúc**: 2026-06-05
> **Trạng thái**: Đang chờ phê duyệt để triển khai
> **Mô tả**: Bản thiết kế kỹ thuật chính thức cho nền tảng học tiếng Nhật N5-N4.

---

## 1. TỔNG QUAN HỆ THỐNG

```
┌─────────────────────────────────────────────────────────────────┐
│                        NIHOLO V1                                │
│         Japanese Learning Platform (N5 → N4)                    │
├──────────────┬──────────────────────────────────────────────────┤
│  Frontend    │  Vue 3 + Inertia.js (SPA) / WanaKana.js          │
│  Backend     │  Laravel 11 (API, Jobs, Middleware)              │
│  Database    │  MySQL 8.0 (core data)                           │
│  Cache/Queue │  Redis 7 (Leaderboard, Throttle, Queue)          │
│  CMS Admin   │  FilamentPHP v3 (free, nhanh, đủ mạnh)          │
│  SRS Engine  │  FSRS 4.5 Algorithm (chính xác hơn SM-2 ~20%)   │
│  PDF Export  │  barryvdh/laravel-dompdf                         │
│  Auth/RBAC   │  Laravel Breeze + spatie/laravel-permission       │
│  Payment     │  Stripe (quốc tế) + VNPay + MoMo (nội địa)      │
└──────────────┴──────────────────────────────────────────────────┘
```

---

## 2. DATABASE SCHEMA (Đã tối ưu)

> **Quyết định**: Dùng **FSRS 4.5** (không phải SM-2).
> FSRS chính xác hơn SM-2 khoảng 20%, là thuật toán tiêu chuẩn mới của cộng đồng Spaced Repetition.

---

### A. Users, Roles & Subscriptions

```sql
-- users
id, name, email, password, avatar_url,
is_premium (boolean, default: false),
email_verified_at, remember_token,
created_at, updated_at

-- roles & permissions (spatie/laravel-permission)
-- Roles: guest | pro | admin

-- subscriptions (Laravel Cashier compatible)
id, user_id, type, stripe_id, stripe_status,
stripe_price, quantity, trial_ends_at, ends_at,
created_at, updated_at

-- payments
id, user_id, amount, currency (VND/USD),
payment_method (enum: stripe|vnpay|momo),
transaction_id, status (enum: pending|success|failed|refunded),
payload_json,  -- raw response từ cổng thanh toán để debug
created_at
```

---

### B. Course Content

```sql
-- courses
id, jlpt_level (enum: N5|N4), title, description,
thumbnail_url, is_published (boolean), order_index,
created_at, updated_at

-- lessons
id, course_id, order_index, title,
theme (ví dụ: Mua sắm | Gia đình | Bệnh viện),
can_do_statement (chuẩn JF: "Tôi có thể..."),
is_locked (boolean),
created_at, updated_at

-- grammar_points
id, lesson_id, title (ví dụ: ～てください),
meaning_vi, meaning_en, formation_rule (text),
jlpt_level (enum: N5|N4), order_index,
created_at, updated_at

-- example_sentences
id, grammar_point_id,
japanese_text, furigana_json,
english_meaning, vietnamese_meaning,
audio_url, created_at, updated_at

-- drag_drop_puzzles
id, lesson_id, example_sentence_id (FK → example_sentences.id),
blocks_json,          -- mảng các khối từ/trợ từ bị cắt rời
correct_order_json,   -- thứ tự đúng để backend validate
difficulty (enum: easy|medium|hard),
created_at, updated_at
```

---

### C. SRS Engine — FSRS 4.5

```sql
-- cards
id, lesson_id,
jlpt_level (enum: N5|N4),
type (enum: vocabulary|kanji|phrase),
front_text, back_meaning, reading_kana,
audio_url, hint_html, tags (JSON array),
image_url (nullable),
created_at, updated_at

-- user_reviews (FSRS 4.5 — đủ cột, v2 bổ sung Leech Quarantine)
id, user_id, card_id,
-- FSRS core
stability (float),        -- độ bền ký ức (ngày)
difficulty (float),       -- độ khó cá nhân hóa (0-1)
retrievability (float),   -- % xác suất nhớ hiện tại
-- State
srs_state (enum: New|Learning|Review|Relearning),
srs_stage (tinyint 0-9), -- Apprentice→Guru→Master→Enlightened→Burned
-- Scheduling
interval_days (integer),
next_review_at (timestamp),  -- "Thời điểm Vàng"
-- Stats
lapses (integer, default: 0),
last_grade (tinyint 1-4),    -- 1:Again 2:Hard 3:Good 4:Easy
last_reviewed_at (timestamp),
-- [MỚI v2] Leech Quarantine & Manual Override
is_leech (boolean, default: false),     -- Tự động gán khi lapses >= 4
is_suspended (boolean, default: false), -- Tạm ngưng: không xuất hiện trong session
manual_override (boolean, default: false), -- User đánh dấu thủ công
created_at, updated_at

-- INDEX(user_id, next_review_at)  -- query "thẻ cần ôn hôm nay"
-- INDEX(user_id, srs_stage)       -- query apprentice_count cho Throttle
-- INDEX(user_id, is_leech)        -- query Leech Quarantine list
```

---

### D. Gamification & Visa Tracking

```sql
-- user_stats (quan hệ 1-1 với users)
user_id (PK, FK → users.id),
total_xp (bigint, default: 0),
current_streak (integer, default: 0),
longest_streak (integer, default: 0),
streak_freezes_inventory (tinyint, default: 0),
league_tier (enum: Bronze|Silver|Gold|Platinum|Diamond),
weekly_xp (integer, default: 0),  -- reset mỗi tuần bởi Cron
last_active_date (date),
updated_at

-- learning_sessions (chứng minh 150h Visa)
id, user_id, session_date (date),
active_duration_seconds (integer),
module_type (enum: Grammar|SRS|Listening|Reading|JLPT_Test),
is_verified (boolean, default: false),  -- chống gian lận AFK
ip_address, user_agent,
created_at

-- notifications
id, user_id,
type (enum: golden_time|streak_warning|league_promotion|quest_complete),
title, body,
is_sent (boolean), sent_at (timestamp nullable),
is_read (boolean), read_at (timestamp nullable),
scheduled_at (timestamp),
reference_id (nullable),
created_at

-- quests
id, title, description,
xp_reward (integer),
quest_type (enum: daily|weekly),
target_count (integer),
reset_at (timestamp),
created_at

-- user_quests
id, user_id, quest_id,
progress (integer, default: 0),
is_completed (boolean, default: false),
completed_at (timestamp nullable),
created_at, updated_at

-- manual_overrides ([MỚI v2] Audit trail cho Leech/Override)
id, user_id, card_id,
action (enum: mark_known|unsuspend_leech|force_suspend),
reason (text nullable),
created_at
```

---

## 3. KIẾN TRÚC LARAVEL

### Cấu trúc thư mục `app/`

```
app/
├── Actions/
│   ├── Gamification/
│   │   ├── UpdateUserStreakAction.php
│   │   ├── AwardXpAction.php
│   │   └── ProcessQuestProgressAction.php
│   ├── SRS/
│   │   ├── SubmitCardReviewAction.php
│   │   ├── MarkCardKnownAction.php         -- [MỚI v2] Manual Override
│   │   └── UnsuspendLeechAction.php        -- [MỚI v2] Giải phóng Leech
│   ├── Learning/
│   │   └── TrackActiveTimeAction.php
│   ├── Onboarding/                       -- [MỚI v2] Invisible Onboarding
│   │   └── MergeGuestSessionAction.php
│   └── Checkout/
│       ├── ProcessStripePaymentAction.php
│       ├── ProcessVnpayPaymentAction.php
│       └── ProcessMomoPaymentAction.php
│
├── Services/
│   ├── FSRSSchedulerService.php
│   ├── VisaReportService.php
│   ├── LeaderboardService.php
│   └── LessonThrottleService.php
│
├── Http/
│   ├── Controllers/ ...
│   └── Middleware/
│       ├── CheckProSubscription.php
│       └── TrackLessonThrottle.php
│
├── Jobs/
│   ├── SendGoldenTimeNotificationJob.php
│   └── GenerateWeeklyLeaderboardJob.php
│
├── Console/Commands/
│   ├── UpdateStreaksCommand.php       -- Cron 00:00 hàng ngày
│   └── ResetWeeklyLeagueCommand.php  -- Cron thứ Hai hàng tuần
│
└── Observers/
    ├── UserReviewObserver.php         -- trigger XP/Quest sau review
    └── LearningSessionObserver.php   -- update Redis sau session
```

---

### Chiến lược Redis

| Key Pattern | Cấu trúc | TTL |
|---|---|---|
| `leaderboard:weekly:{level}` | Sorted Set (ZADD/ZREVRANGE) | 7 ngày |
| `user:{id}:apprentice_count` | String (integer) | 1 ngày |
| `user:{id}:session_active` | String (boolean) | 5 phút |
| `notification:queue:{userId}` | List | — |

---

### Routing Strategy

```php
// routes/web.php → Inertia SPA (Session + CSRF)

// [MỚI v2] Public routes — Invisible Onboarding
Route::get('/onboarding/demo', OnboardingDemoController::class);
Route::post('/onboarding/merge-session', MergeGuestSessionAction::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class);
    Route::get('/learn/{lesson}', LessonController::class);
    Route::post('/review', ReviewController::class);
    Route::post('/review/override', ReviewOverrideController::class); // [MỚI v2]
    Route::post('/track-time', SessionController::class);

    Route::middleware('pro')->group(function () {
        Route::get('/boss-arena', BossArenaController::class);
        Route::get('/export/visa-report', VisaReportController::class);
    });
});

// routes/api.php → Stateless (Sanctum token, cho mobile sau này)
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('/review', Api\ReviewController::class);
    Route::post('/review/override', Api\ReviewOverrideController::class);
    Route::get('/cards/due', Api\DueCardsController::class);
});
```

---

## 4. PHÂN QUYỀN (RBAC)

| Role | Quyền truy cập |
|---|---|
| `guest` | Bài 1-3 N5, tối đa 50 thẻ SRS, không xuất PDF |
| `pro` | Toàn bộ tính năng, xuất PDF 150h Visa, Boss Arena, Shadowing |
| `admin` | FilamentPHP CMS: CRUD nội dung, duyệt payment, báo cáo |

---

## 5. TẦM NHÌN TƯƠNG LAI — TÍCH HỢP OPENAI API (Coming Soon)

Vì đã có sẵn tài khoản OpenAI platform, đây là 3 tính năng có tính khả thi cực cao, dễ implement (low-hanging fruit) nhưng mang lại giá trị to lớn cho app, sẽ được bổ sung vào roadmap:

| Tính năng | API Sử dụng | Cơ chế hoạt động (Dự kiến) | Value |
|---|---|---|---|
| **AI Sensei (Giải thích ngữ cảnh)** | `gpt-4o-mini` | Khi user ấn nút "Hỏi AI" trên 1 thẻ SRS/Grammar khó hiểu, prompt GPT-4o-mini giải thích sự khác biệt (ví dụ: は vs が) dựa trên ngữ cảnh cụ thể của câu đó. Dữ liệu trả về được cache lại vào DB để tiết kiệm token cho các user sau. | Cực cao, thay thế giáo viên thật. |
| **Auto-Mnemonic Generator** | `gpt-4o-mini` | Dùng AI sinh "Mẹo ghi nhớ" (Mnemonics) tự động cho Kanji và Từ vựng. Admin chỉ việc review lại trong CMS thay vì phải nghĩ ra hàng ngàn câu chuyện. | Tiết kiệm 90% thời gian nhập liệu Mnemonic. |
| **Dynamic Roleplay Chat** | `gpt-4o` | Một màn hình chat đơn giản mô phỏng tình huống (ví dụ: Gọi món tại Izakaya). AI đóng vai bồi bàn, user phải gõ câu trả lời bằng tiếng Nhật. System prompt giới hạn AI chỉ dùng từ vựng/ngữ pháp N5-N4. | Luyện giao tiếp thực chiến cực mạnh. |

---

## 6. LỘ TRÌNH TRIỂN KHAI (8 tuần)

| Tuần | Phase | Nội dung | Lưu ý quan trọng |
|---|---|---|---|
| 1 | Foundation | Laravel 11, Breeze + Inertia + Vue 3, Spatie, MySQL + Redis | Đăng ký VNPay/MoMo ngay tuần này |
| 2 | Database & CMS | Migration + Models, FilamentPHP, Seeder mẫu | Admin nhập liệu song song |
| 3 | SRS Engine | FSRS 4.5, API review, track-time ping | Phase phức tạp nhất, buffer 0.5 tuần |
| 4 | Frontend Core | Dashboard + 150h bar, Flashcard UI, WanaKana.js | Test mobile keyboard UX |
| 5 | Interactive UI | Drag-and-Drop, Artifact Swipes, Noisy Listening | vuedraggable mobile cần test kỹ |
| 6 | Gamification | Redis Leaderboard, Streak Cron, Quest, Push Notif | Timezone phải đồng bộ UTC+7 |
| 7 | Monetization | Stripe + VNPay + MoMo, PDF export, Middleware Paywall | Test sandbox kỹ |
| 8 | UAT & Launch | Bug fix, performance, SEO, deploy | Load test Redis + MySQL |

---

## 6. PACKAGES

### Backend (Composer)
- `spatie/laravel-permission` → RBAC
- `laravel/cashier-stripe` → Stripe subscription
- `barryvdh/laravel-dompdf` → PDF 150h Visa
- `filament/filament` → CMS Admin Panel
- `predis/predis` → Redis client

### Frontend (NPM)
- `@inertiajs/vue3` → SPA bridge
- `pinia` → State management
- `vuedraggable` (sortablejs) → Drag-and-Drop Grammar Builder
- `wanakana` → Auto Hiragana input
- `vue-chartjs` → Dashboard SRS forecast graph

---

## 7. CÁC QUYẾT ĐỊNH KIẾN TRÚC

| # | Quyết định | Lý do |
|---|---|---|
| 1 | FSRS 4.5 thay SM-2 | Chính xác hơn 20%, tiêu chuẩn 2024 |
| 2 | FilamentPHP thay Nova | Miễn phí, đủ mạnh |
| 3 | Inertia.js | SPA mượt, dùng chung auth session |
| 4 | Pinia cho Vue state | Quản lý SRS session, tránh mất data khi refresh |
| 5 | Redis Sorted Sets cho Leaderboard | O(log N), không đụng MySQL |
| 6 | Observer Pattern | Tách logic XP/Quest/Notification khỏi Controller |
| 7 | `is_verified` trong learning_sessions | Chống gian lận AFK cho 150h Visa |
| 8 | `payload_json` trong payments | Debug khi VNPay/MoMo có sự cố |
| 9 | Invisible Onboarding (Delayed Registration) | Tăng 20% retention ngày 1 (học từ Duolingo) |
| 10 | Leech Quarantine + Manual Override | Tránh SRS Burnout, trả quyền kiểm soát cho người học |
| 11 | Progressive Hint Engine (3 giai đoạn) | Quản lý cognitive load tối ưu (học từ Bunpro) |
| 12 | Predictive Level-Up Cue | Mồi nhử tâm lý "không thể dừng" (học từ WaniKani) |
| 13 | Hybrid Audio (TTS + Irodori real voice) | TTS cho flashcard, giọng người thật cho Noisy Quests |
