# Niholo V1 — Kịch bản Kỹ thuật Chi tiết (Technical Screenplay)

> **Mục đích**: Tài liệu này mô tả toàn bộ luồng kỹ thuật cụ thể (flow, API contract, component structure)
> cho cả Backend (Laravel) và Frontend (Vue 3 + Inertia.js).
> Đây là "kịch bản" để dev đọc và code — không cần đoán thêm gì.
>
> **Cập nhật lần cuối**: 2026-06-05 (v2 — Bổ sung 5 Blind Spots: Invisible Onboarding, Leech Quarantine, Progressive Hint, Level-Up Cue, Hybrid Audio)

---

## MỤC LỤC

1. [Luồng Xác thực & Phân quyền (+ Invisible Onboarding)](#1-luồng-xác-thực--phân-quyền)
2. [Luồng SRS — Ôn tập Flashcard (+ Leech + Progressive Hint)](#2-luồng-srs--ôn-tập-flashcard)
3. [Luồng Track Time — Chứng minh 150h](#3-luồng-track-time--chứng-minh-150h)
4. [Luồng Drag-and-Drop Grammar](#4-luồng-drag-and-drop-grammar)
5. [Luồng Leaderboard Realtime](#5-luồng-leaderboard-realtime)
6. [Luồng Gamification — XP & Streak (+ Level-Up Cue)](#6-luồng-gamification--xp--streak)
7. [Luồng Thanh toán & Cấp quyền Pro](#7-luồng-thanh-toán--cấp-quyền-pro)
8. [Luồng Xuất PDF 150h Visa](#8-luồng-xuất-pdf-150h-visa)
9. [Luồng Push Notification "Thời điểm Vàng"](#9-luồng-push-notification-thời-điểm-vàng)
10. [Cấu trúc Component Vue](#10-cấu-trúc-component-vue)

---

## 1. Luồng Xác thực & Phân quyền

> **[BLIND SPOT #1 ĐÃ SỬA]** Học từ Duolingo: Áp dụng "Invisible Onboarding" —
> người dùng mới **không bị ép đăng ký** ngay. Chỉ hiện popup sau khi họ đã trải nghiệm và nhận XP đầu tiên.

### 1.1 Luồng Người Dùng Mới — Invisible Onboarding (Delayed Registration)

```
[Guest chưa đăng nhập truy cập niholo.com]
    ↓
Landing Page hiển thị nút: "Thử ngay — Không cần đăng ký"
    ↓
Guest vào thẳng trang /onboarding/demo
    → Chơi thử 1 bài Drag-and-Drop Grammar (bài N5 Lesson 1)
    → Hoặc học 5 thẻ flashcard đầu tiên
    → Tiến trình tạm lưu trong localStorage (session guest)
    ↓
Sau khi hoàn thành → Nhận animation "+15 XP"
    → Popup xuất hiện (KHÔNG phải modal chặn, là bottom sheet nhẹ nhàng):
        "🎉 Bạn vừa kiếm được 15 XP đầu tiên!
         Lưu tiến trình để không mất công sức?
         [Tạo tài khoản — 3 giây] [Để sau]"
    ↓
Nếu chọn "Tạo tài khoản":
    → Laravel Breeze Register
    → Migrate localStorage progress vào DB (merge guest session)
    → Gán role 'guest' (free tier)
    → Tạo user_stats record
Nếu chọn "Để sau":
    → Cho phép tiếp tục thêm 1-2 bài nữa
    → Popup xuất hiện lại sau bài thứ 3 (không spam hơn)
```

**Routes cần thêm**:
```php
// routes/web.php — public, không cần auth
Route::get('/onboarding/demo', OnboardingDemoController::class);
Route::post('/onboarding/merge-session', MergeGuestSessionAction::class);
```

**Lưu ý FE**: Progress guest lưu trong `localStorage` dưới key `niholo_guest_session`:
```json
{
  "xp": 15,
  "completed_cards": [1, 2, 3, 4, 5],
  "completed_puzzles": [1]
}
```

---

### 1.2 Luồng Returning User — Màn hình Chào mừng Đặc biệt

```
User đăng nhập sau khi bỏ học >= 7 ngày
    ↓
Middleware kiểm tra: user_stats.last_active_date < today - 7
    ↓
Thay vì load Dashboard thông thường:
    → Inertia::render('Onboarding/WelcomeBack')
        → Mascot buồn/vui (tuỳ số ngày vắng)
        → "Bạn đã vắng 9 ngày! Hãy ôn lại kiến thức cũ trước nhé 👋"
        → Nút: "Ôn tập nhanh (10 thẻ)" → load mini review session
        → Nút: "Xem tôi đang ở đâu" → Dashboard bình thường
        → Hiển thị số thẻ tồn đọng cần ôn: "Bạn có 47 thẻ chờ ôn tập"
```

**Logic Mascot Emotion**:
| Số ngày vắng | Mascot state | Tin nhắn |
|---|---|---|
| 1-3 ngày | Hơi buồn | "Nihoko nhớ bạn một chút~ 🌸" |
| 4-7 ngày | Buồn | "Streak của bạn đang ngủ đông rồi 😴" |
| 8-14 ngày | Buồn + lo | "Bạn có ổn không? Học một chút thôi nhé 🥺" |
| >14 ngày | Reset vui vẻ | "Chào mừng trở lại! Hãy bắt đầu lại từ đầu! 🎉" |

---

### 1.3 Luồng Auth thông thường (đã đăng nhập)

```
User đăng nhập
    → Session-based auth (web.php / Inertia)
    → Mỗi request qua Middleware: CheckProSubscription
        → Đọc users.is_premium + subscriptions.stripe_status
        → Nếu không đủ điều kiện → trả về Inertia::render('Paywall')
```

**Middleware `CheckProSubscription.php`**:
```php
// Logic kiểm tra:
// 1. User có role 'pro' không? (spatie)
// 2. subscriptions.stripe_status == 'active' hoặc ends_at > now()
// Nếu sai → redirect về trang Upgrade
```

### Frontend (Vue) — Layout

```
Layout chính (AppLayout.vue)
    → Nhận prop: auth.user (từ Inertia shared data)
    → auth.user.is_premium → hiện/ẩn nút "Boss Arena", "Export PDF"
    → auth.user == null → hiển thị GuestLayout (không có sidebar đầy đủ)
    → Mọi route guard ở FE chỉ là UI — backend là tầng bảo vệ thực sự
```

---

## 2. Luồng SRS — Ôn tập Flashcard

### Kịch bản người dùng
> User mở trang ôn tập → thấy thẻ từ → gõ câu trả lời → nhấn Enter → hệ thống tính điểm → FSRS cập nhật lịch → next card.

### Backend

**API Endpoint**: `POST /review`

**Request body**:
```json
{
  "card_id": 42,
  "grade": 3,
  "response_time_ms": 2400
}
```

**Luồng xử lý**:
```
ReviewController@store
    → Validate (card_id, grade 1-4)
    → Kiểm tra: user_reviews.is_suspended == true → reject (thẻ Leech)
    → Gọi SubmitCardReviewAction
        → Lấy user_reviews record hiện tại của card này
        → Gọi FSRSSchedulerService::calculate($review, $grade)
            → Tính stability mới
            → Tính difficulty mới
            → Tính interval_days mới
            → Tính next_review_at = now() + interval_days
        → Update/Create user_reviews record
        → [LEECH CHECK] Nếu lapses >= 4:
            → SET user_reviews.is_leech = true
            → SET user_reviews.is_suspended = true
            → Không schedule next_review_at
            → Trả về flag: { leech_detected: true, card_id }
        → Update Redis: DECR/INCR user:{id}:apprentice_count
        → Dispatch SendGoldenTimeNotificationJob (delay = next_review_at)
    → UserReviewObserver::updated() tự trigger:
        → AwardXpAction (XP tùy grade)
        → ProcessQuestProgressAction
    → Trả về Inertia response: { next_card, xp_gained, new_streak, leech_detected }
```

**API Manual Override** (người học đánh dấu "Tôi đã biết"):
```
POST /review/override
Request: { card_id: 42, action: "mark_known" | "unsuspend_leech" }

MarkKnownAction:
    → SET user_reviews.srs_stage = 9 (Burned — không ôn nữa)
    → SET user_reviews.is_suspended = true
    → Log vào bảng manual_overrides (audit trail)

UnsuspendLeechAction:
    → SET user_reviews.is_leech = false
    → SET user_reviews.is_suspended = false
    → RESET lapses = 0, stability = 1.0
    → Thêm vào queue ôn tập ngay hôm nay
```

**FSRSSchedulerService — logic cốt lõi**:
```
Grade 1 (Again):
    stability = stability * 0.2
    difficulty = min(difficulty + 0.2, 1.0)
    srs_state = Relearning
    interval_days = 1
    lapses += 1
    → Nếu lapses >= 4: trigger Leech Quarantine

Grade 2 (Hard):
    stability = stability * 1.2
    interval_days = round(stability)

Grade 3 (Good):
    retrievability = exp(ln(0.9) / stability * interval_days)
    stability = stability * (e^(0.1 * (11 - difficulty)) * retrievability)
    interval_days = round(stability)

Grade 4 (Easy):
    stability = stability * 1.3 * (2 - difficulty)
    difficulty = max(difficulty - 0.15, 0.1)
    interval_days = round(stability * 1.3)

Sau tất cả:
    next_review_at = Carbon::now()->addDays(interval_days)
```

> **Schema bổ sung cho `user_reviews`** (xem 00_implementation_plan.md):
> Cần thêm: `is_leech (boolean)`, `is_suspended (boolean)`, `manual_override (boolean)`

### 2.2 Frontend (Vue) — Progressive Hint Engine

> **[BLIND SPOT #3 ĐÃ SỬA]** Học từ Bunpro & WaniKani: Progressive Hint 3 giai đoạn
> thay vì hiện toàn bộ hint ngay lập tức.

**Component**: `pages/SRS/ReviewSession.vue`

```
State (Pinia: useSrsStore):
    currentCard: Card | null
    sessionQueue: Card[]          -- danh sách thẻ cần ôn hôm nay
    inputAnswer: string
    isRevealed: boolean
    hintLevel: number (0-3)       -- [MỚI] cấp độ gợi ý hiện tại
    sessionStats: { correct, wrong, xpGained, cardsToLevelUp }

Template flow:
    1. Hiển thị front_text của card
    2. <input> với WanaKana binding → tự chuyển romaji → hiragana
    3. User gõ + Enter → so sánh với back_meaning
       → Đúng hoàn toàn: grade = 3 (Good), tô xanh
       → Gần đúng: hiện nút chọn Hard/Good
       → Sai: grade = 1 (Again), tô đỏ
           → hintLevel = 0 (chưa hiện gì)

    [PROGRESSIVE HINT ENGINE]
    Người dùng nhấn Space (hoặc nút "Gợi ý"):
        hintLevel = 1 → Hiển thị nghĩa cơ bản tiếng Việt/Anh (mờ nhạt)
        hintLevel = 2 → Highlight (bôi xanh) cấu trúc ngữ pháp liên quan
        hintLevel = 3 → Hiện đầy đủ: giải thích chi tiết + câu ví dụ
    → Mỗi lần dùng hint: trừ điểm XP nhận được (không penalize grade)

    4. Sau 1.5s → POST /review với grade
    5. Nhận response:
       → Load card tiếp theo
       → [LEECH WARNING] Nếu response.leech_detected:
           → Hiện toast: "Thẻ này đang trở thành Leech! Xem Mẹo ghi nhớ?"
    6. Khi hết queue → hiển thị màn hình Summary

    [MANUAL OVERRIDE BUTTON]
    Hiện nút nhỏ (icon) góc phải card:
        🏳️ "Tôi đã biết" → POST /review/override { action: mark_known }
        (Confirm modal: "Thẻ này sẽ không xuất hiện nữa. Chắc chắn?")

Animation:
    Card flip (CSS 3D transform) khi reveal
    XP pop-up (+15 XP) animation khi đúng
    Shake animation khi sai
    Hint glow effect (blur → clear) khi reveal từng cấp gợi ý
    Leech icon (🐛) xuất hiện nhẹ nhàng khi is_leech = true
```

**Màn hình Leech Quarantine** (`pages/SRS/LeechQuarantine.vue`):
```
- Danh sách tất cả thẻ is_leech = true của user
- Mỗi thẻ hiển thị: từ + số lần sai (lapses) + Mẹo ghi nhớ (Mnemonic)
- Nút: "Giải phóng thẻ này" → POST /review/override { action: unsuspend_leech }
- Nút: "Bỏ hẳn" → POST /review/override { action: mark_known }
```

---

## 3. Luồng Track Time — Chứng minh 150h

### Kịch bản
> Mọi trang học đều ping server mỗi 60 giây để chứng minh học viên đang học chủ động.

### Backend

**API Endpoint**: `POST /track-time`

**Request body**:
```json
{
  "module_type": "SRS",
  "session_token": "uuid-generated-on-session-start"
}
```

**Luồng**:
```
TrackActiveTimeAction
    → Kiểm tra Redis key: user:{id}:session_active
        → Nếu key tồn tại: cộng thêm 60s vào learning_sessions record hôm nay
        → Nếu key không tồn tại: không cộng (user AFK > 5 phút)
    → Mỗi khi user tương tác (gõ phím, click):
        → Frontend gọi SET user:{id}:session_active = true, TTL 5 phút
    → Cuối ngày hoặc khi user logout:
        → LearningSessionObserver kiểm tra:
            active_duration_seconds > 120 → is_verified = true
```

### Frontend (Vue)

**Composable**: `composables/useTimeTracker.ts`

```javascript
// Mount khi vào bất kỳ trang học nào
onMounted(() => {
    // Ping server mỗi 60s
    pingInterval = setInterval(() => {
        axios.post('/track-time', { module_type: props.moduleType })
    }, 60000)

    // Reset "active" flag khi user tương tác
    document.addEventListener('keydown', resetActiveTimer)
    document.addEventListener('click', resetActiveTimer)
})

// resetActiveTimer: gọi POST /active-ping mỗi khi có tương tác
// → Backend SET Redis TTL 5 phút
```

---

## 4. Luồng Drag-and-Drop Grammar

### Kịch bản
> Màn hình hiển thị câu tiếng Nhật bị xáo trộn → học viên kéo thả các khối từ vào đúng vị trí.

### Backend

**Data flow**:
```
GET /lessons/{lesson}/puzzle/{puzzle_id}
    → Trả về drag_drop_puzzles record:
        blocks_json: ["を", "食べます", "私は", "ラーメン"]  (đã xáo trộn)
        -- KHÔNG trả về correct_order_json cho frontend

POST /lessons/{lesson}/puzzle/{puzzle_id}/submit
    Request: { "answer_order": [2, 0, 3, 1] }
    → PuzzleController so sánh answer_order với correct_order_json
    → Trả về: { correct: true/false, correct_sentence: "私はラーメンを食べます" }
```

### Frontend (Vue)

**Component**: `pages/Grammar/DragDropPuzzle.vue`

```
State:
    blocks: Block[]      -- lấy từ blocks_json, đã xáo trộn
    answerSlots: []      -- các ô trống để thả vào
    isSubmitted: boolean

Template:
    Khu vực "nguyên liệu" (source): hiển thị blocks chưa dùng
    Khu vực "câu trả lời" (target): các ô trống có thứ tự

    Dùng vuedraggable:
        <draggable v-model="blocks" group="puzzle" />
        <draggable v-model="answerSlots" group="puzzle" />

    Nút Submit → POST answer_order
    → Đúng: animate confetti, hiện nghĩa câu, unlock card tiếp
    → Sai: shake, highlight khối sai, cho thử lại (max 3 lần)
```

---

## 5. Luồng Leaderboard Realtime

### Backend

**Cập nhật điểm (xảy ra trong AwardXpAction)**:
```php
// Mỗi khi user nhận XP:
Redis::zadd("leaderboard:weekly:N5", $totalWeeklyXp, $userId);
// Đồng thời update MySQL: user_stats.weekly_xp
```

**API lấy Leaderboard**:
```
GET /leaderboard?level=N5
    → LeaderboardService::getTop50('N5')
        → Redis::zrevrange("leaderboard:weekly:N5", 0, 49, 'WITHSCORES')
        → Lấy user names từ MySQL theo danh sách userId
        → Trả về array rank: [{ rank, user_id, name, avatar, xp }]
    → Cache kết quả này thêm 60s (tránh hit Redis liên tục)
```

**Cron Job Reset hàng tuần** (thứ Hai 00:00 UTC+7):
```php
// ResetWeeklyLeagueCommand
// 1. Lấy top users của tuần cũ → promote/demote league_tier
// 2. Redis::del("leaderboard:weekly:N5")
// 3. Reset user_stats.weekly_xp = 0 cho tất cả user
```

### Frontend

**Component**: `pages/Leaderboard/WeeklyRanking.vue`
```
- Polling GET /leaderboard mỗi 30s (hoặc dùng Laravel Echo + Redis pub/sub sau)
- Highlight row của current user
- Hiển thị badge league_tier bằng màu: Bronze/Silver/Gold/Platinum/Diamond
- Hiển thị countdown đến khi league reset
```

---

## 6. Luồng Gamification — XP & Streak

### XP System

| Hành động | XP nhận được |
|---|---|
| Trả lời đúng lần đầu (grade 3-4) | +15 XP |
| Trả lời sai rồi đúng (grade 2) | +5 XP |
| Hoàn thành 1 drag-drop puzzle | +20 XP |
| Hoàn thành 1 listening quest | +25 XP |
| Hoàn thành daily quest | +50 XP |
| Hoàn thành weekly quest | +200 XP |

### Streak System

**Cron Job `UpdateStreaksCommand`** — chạy 00:05 mỗi ngày (UTC+7):
```
Với mỗi user có last_active_date:
    Nếu last_active_date == hôm qua:
        current_streak += 1
        longest_streak = max(longest_streak, current_streak)
    Nếu last_active_date < hôm qua - 1:
        Nếu streak_freezes_inventory > 0:
            streak_freezes_inventory -= 1  -- dùng "Bùa đóng băng"
        Else:
            current_streak = 0  -- mất streak
```

### Frontend Mascot Notifications & Predictive Level-Up Cue

> **[BLIND SPOT #3 ĐÃ SỬA]** Học từ WaniKani: Predictive Level-Up Cue — mồi nhử tâm lý khi gần đủ XP thăng hạng.

```
Mascot trạng thái:
    current_streak >= 7  → Mascot vui, animation nhảy múa
    current_streak == 0  → Mascot buồn, gửi notification động viên
    next_review_at sắp đến → Mascot nhắc nhở

Streak Freeze UI:
    Hiển thị số bùa còn lại (🧊 x2)
    Nút mua thêm bằng XP (shop nhỏ)

[PREDICTIVE LEVEL-UP CUE — Mồi nhử tâm lý]
Frontend logic (useSrsStore):
    cardsToLevelUp = số thẻ cần ôn để user đủ XP thăng hạng liều tiếp
    Nếu sessionStats.cardsToLevelUp <= 10:
        → ProgressBar chuyển sang màu vàng + pulse animation
        → Hiển thị nhãn: "⚡ Chỉ còn {n} thẻ nữa là lên hạng!"
        → Mascot phấn khích, animation cổ vũ
    Nếu cardsToLevelUp <= 3:
        → Toàn bộ progress bar nhấp nháy (blink effect)
        → Tiếng nhạc nhỏ (sound effect, nếu user cho phép)
        → Mức độ "không thể dừng"

Level-Up Animation (khi đủ XP):
    → Full-screen confetti 2 giây
    → Badge hạng mới hiện ra (ví dụ: Silver → Gold)
    → Mascot cúi chào trên nền particle
    → Chia sẻ lên mạng xã hội (optional)
```

---

## 7. Luồng Thanh toán & Cấp quyền Pro

### Stripe (Quốc tế)

```
Frontend: nút "Nâng cấp Pro"
    → Gọi POST /checkout/stripe
    → Backend tạo Stripe Checkout Session (Laravel Cashier)
    → Redirect user sang Stripe hosted page
    → Sau khi thanh toán: Stripe gọi Webhook /stripe/webhook
    → Backend:
        → Cập nhật subscriptions record
        → SET users.is_premium = true
        → Gán role 'pro' (spatie)
        → Ghi payments record (status: success)
```

### VNPay / MoMo (Nội địa)

```
Frontend: nút "Thanh toán VNPay"
    → Gọi POST /checkout/vnpay
    → ProcessVnpayPaymentAction:
        → Tạo URL thanh toán VNPay (ký HMAC-SHA512)
        → Lưu payments record (status: pending)
        → Redirect user sang VNPay
    → VNPay redirect về /checkout/vnpay/return
    → Backend verify chữ ký response
    → Nếu hợp lệ:
        → Cập nhật payments.status = success
        → SET users.is_premium = true
        → Gán role 'pro'
```

---

## 8. Luồng Xuất PDF 150h Visa

### Backend

**API**: `GET /export/visa-report` (chỉ Pro)

```
Middleware CheckProSubscription chặn Guest

VisaReportController
    → Gọi VisaReportService::generate($userId)
        → Query learning_sessions WHERE user_id = ? AND is_verified = true
        → GROUP BY session_date, module_type
        → Tính total_hours = SUM(active_duration_seconds) / 3600
        → Kiểm tra đủ 150h chưa
        → Render Blade template: visa-report.blade.php
            → Họ tên, ngày sinh, tổng giờ, bảng thống kê theo tháng
            → Biểu đồ đơn giản bằng CSS/inline SVG
        → DomPDF::loadHTML($html)->download('niholo-150h-report.pdf')
```

### Frontend

```
Dashboard hiển thị:
    ProgressBar: 87h / 150h (58%)
    Nút "Xuất Báo cáo PDF" (disabled nếu < 150h, hoặc nếu là Guest)
    Tooltip cho Guest: "Nâng cấp Pro để xuất báo cáo Visa"
```

---

## 9. Luồng Push Notification "Thời điểm Vàng"

```
Sau mỗi lần ôn tập:
    SubmitCardReviewAction dispatch:
        SendGoldenTimeNotificationJob::dispatch($userId, $cardId)
            ->delay($next_review_at)

Khi Job chạy:
    1. Kiểm tra user còn active không (chưa ôn lại bằng cách khác)
    2. Ghi notifications record (is_sent = false)
    3. Gửi qua:
       - Web Push (Vapid keys — tích hợp webpush-notification)
       - Hoặc Email fallback nếu user chưa cho phép Push
    4. Cập nhật notifications.is_sent = true, sent_at = now()

Tránh spam:
    Gom nhóm: nếu user có > 20 thẻ đến hạn → gửi 1 notification tổng
    Giới hạn: tối đa 3 notification/ngày/user
```

---

## 10. Cấu trúc Component Vue

### Tổ chức pages/ và components/

```
resources/js/
├── pages/
│   ├── Auth/
│   │   ├── Login.vue
│   │   └── Register.vue
│   ├── Dashboard/
│   │   └── Index.vue          -- 150h progress, SRS forecast chart
│   ├── SRS/
│   │   ├── ReviewSession.vue  -- Typed-recall flashcard
│   │   └── LeechQuarantine.vue -- Khu vực cách ly thẻ khó
│   ├── Grammar/
│   │   ├── LessonView.vue     -- Danh sách grammar points
│   │   └── DragDropPuzzle.vue -- Drag-and-drop builder
│   ├── Listening/
│   │   └── EavesdroppingQuest.vue
│   ├── Reading/
│   │   └── ArtifactSwipe.vue  -- LINE message, menu, biển báo
│   ├── BossArena/
│   │   └── JLPTExam.vue       -- Timer, JLPT mock test
│   ├── Leaderboard/
│   │   └── WeeklyRanking.vue
│   └── Settings/
│       ├── Profile.vue
│       └── Subscription.vue
│
├── components/
│   ├── ui/
│   │   ├── FlashCard.vue      -- Card flip component
│   │   ├── XpPopup.vue        -- +XP animation popup
│   │   ├── StreakBadge.vue    -- Streak counter + mascot
│   │   ├── ProgressBar.vue    -- 150h progress
│   │   └── MascotWidget.vue   -- Linh vật cảm xúc
│   ├── layout/
│   │   ├── AppLayout.vue
│   │   ├── Sidebar.vue
│   │   └── TopNav.vue
│   └── modals/
│       ├── UpgradeModal.vue   -- Paywall upsell
│       └── StreakFreezeModal.vue
│
├── stores/ (Pinia)
│   ├── useSrsStore.ts         -- SRS session state
│   ├── useUserStore.ts        -- User profile, XP, streak
│   └── useLeaderboardStore.ts -- Leaderboard cache
│
└── composables/
    ├── useTimeTracker.ts      -- 60s ping composable
    ├── useWanaKana.ts         -- Auto hiragana input
    └── useFsrsGrade.ts        -- Grade selection logic
```

---

## 11. Tích hợp OpenAI API (Coming Soon)

Với platform API đã có sẵn của OpenAI, chúng ta sẽ mở khóa các tính năng "Super App" mà không tốn nhiều công sức code:

### 11.1 Tính năng "AI Sensei" (Giải thích cá nhân hóa)

**Nỗi đau**: Giải thích tĩnh (text tĩnh) không bao giờ đủ với mọi người dùng. Học viên thường thắc mắc "Tại sao chỗ này dùng は mà không phải が?".
**Giải pháp**: Tích hợp GPT-4o-mini với prompt được tối ưu.

**Luồng xử lý (API Contract)**:
```
POST /api/ai/ask
Request: {
  "card_id": 105, // Hoặc grammar_point_id
  "user_question": "Tại sao câu này lại dùng に thay vì で?"
}

Backend:
    → Lấy nội dung câu ví dụ + ngữ pháp tương ứng từ DB.
    → Kiểm tra Cache (Redis) xem có ai hỏi câu này chưa (tiết kiệm API call).
    → Build System Prompt: "Bạn là Nihoko, một giáo viên tiếng Nhật N5/N4 thân thiện..."
    → Gọi OpenAI API (gpt-4o-mini).
    → Trả kết quả về cho FE.
```

### 11.2 Auto-Mnemonic Generator (Sinh mẹo ghi nhớ)

**Nỗi đau**: Tạo ra hàng ngàn câu chuyện Mnemonic cho Kanji/Từ vựng tốn hàng tháng trời.
**Giải pháp**: Sinh tự động bằng OpenAI API khi Admin nhập liệu.

**Luồng xử lý (FilamentPHP Action)**:
```php
// Trong Filament Resource của Card
Action::make('generateMnemonic')
    ->action(function (Card $record) {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Create a funny, memorable English/Vietnamese mnemonic for this Japanese word/Kanji. Limit to 2 sentences.'],
                ['role' => 'user', 'content' => "Word: {$record->word}, Meaning: {$record->meaning}, Reading: {$record->reading}"]
            ]
        ]);
        $record->update(['hint_html' => $response->choices[0]->message->content]);
    });
```
*Lưu ý: Chỉ tốn chưa tới $0.001 mỗi từ, 2000 từ chỉ tốn ~$2!*

---

## PHỤ LỤC: API Contract Summary

| Method | Endpoint | Auth | Mô tả |
|---|---|---|---|
| POST | `/review` | auth | Submit flashcard answer, chạy FSRS |
| POST | `/track-time` | auth | Ping 60s cộng giờ học |
| POST | `/active-ping` | auth | Reset Redis TTL "đang học" |
| GET | `/cards/due` | auth | Lấy danh sách thẻ cần ôn hôm nay |
| GET | `/lessons/{id}/puzzle/{id}` | auth | Lấy puzzle data |
| POST | `/lessons/{id}/puzzle/{id}/submit` | auth | Submit puzzle answer |
| GET | `/leaderboard` | auth | Top 50 user tuần này |
| POST | `/checkout/stripe` | auth | Khởi tạo Stripe Checkout |
| POST | `/checkout/vnpay` | auth | Khởi tạo VNPay payment URL |
| GET | `/checkout/vnpay/return` | public | VNPay callback |
| GET | `/export/visa-report` | pro | Xuất PDF 150h |
| GET | `/dashboard` | auth | Inertia render Dashboard |
