# Niholo V1 — Kế hoạch Triển khai Chi tiết (Execution Phases)

> **Mục đích**: Tài liệu này chia nhỏ dự án thành **10 Phase (Giai đoạn)** thực thi. Mỗi Phase là một khối công việc độc lập, có mục tiêu rõ ràng, định nghĩa Backend/Frontend task và **bắt buộc phải có Testing**.
> **Chiến lược Token Limit**: Do quy mô dự án lớn, chúng ta sẽ làm việc theo từng Phase. Khi xong một Phase, chúng ta có thể chuyển sang một cửa sổ chat mới, chỉ cần cung cấp lại thư mục `_ai-brain/` để AI lấy lại Context và tiếp tục code Phase tiếp theo.

---

## MỤC LỤC PHASES
1. [✅ Phase 1: Foundation & Auth Setup](#phase-1-foundation--auth-setup)
2. [✅ Phase 2: Database Modeling & CMS Admin](#phase-2-database-modeling--cms-admin)
3. [✅ Phase 3: Data Strategy (Seeding & Audio Generation)](#phase-3-data-strategy-seeding--audio-generation)
4. [✅ Phase 4: Core SRS Engine (FSRS 4.5) & API](#phase-4-core-srs-engine-fsrs-45--api)
5. [✅ Phase 5: Vue Frontend Foundation & Invisible Onboarding](#phase-5-vue-frontend-foundation--invisible-onboarding)
6. [✅ Phase 6: Interactive Learning UI (Drag & Drop, Artifacts)](#phase-6-interactive-learning-ui-drag--drop-artifacts)
7. [✅ Phase 7: Gamification Engine (Leaderboard, XP, Streak)](#phase-7-gamification-engine-leaderboard-xp-streak)
8. [Phase 8: Advanced SRS UX (Leech, Hints, Level-Up)](#phase-8-advanced-srs-ux-leech-hints-level-up)
9. [Phase 9: Time Tracking (150h) & Monetization (Paywall)](#phase-9-time-tracking-150h--monetization-paywall)
10. [Phase 10: AI Integrations & Launch Prep](#phase-10-ai-integrations--launch-prep)

---

## ✅ Phase 1: Foundation & Auth Setup
**Mục tiêu**: Dựng khung xương cho dự án, cấu hình môi trường, cài đặt các package cốt lõi và hệ thống xác thực.

*   **Backend Tasks**:
    *   Init Laravel 11, cấu hình MySQL, Redis trong `.env`.
    *   Cài đặt Laravel Breeze (Vue 3 + Inertia stack).
    *   Cài đặt `spatie/laravel-permission` và cấu hình 3 role: `guest`, `pro`, `admin`.
    *   Tạo Custom Middleware (VD: `CheckProSubscription` dạng khung rỗng để dùng sau).
*   **Frontend Tasks**:
    *   Tái cấu trúc thư mục JS theo chuẩn đã định (`pages/`, `components/ui`, `components/layout`, `stores/`).
    *   Cài đặt Pinia, TailwindCSS (cấu hình màu sắc, typography Nhật Bản).
    *   Tạo Layout cơ bản: `AppLayout.vue`, `GuestLayout.vue`.
*   **Testing Tasks**:
    *   `Feature`: Test luồng Register/Login của Breeze hoạt động.
    *   `Unit`: Test việc tự động gán role `guest` khi đăng ký user mới.
*   **Deliverable**: Chạy được `npm run dev` và trang chủ Laravel Breeze hiển thị, user có thể đăng nhập.

---

## ✅ Phase 2: Database Modeling & CMS Admin
**Mục tiêu**: Xây dựng toàn bộ lược đồ cơ sở dữ liệu và giao diện nhập liệu cho Admin.

*   **Backend Tasks**:
    *   Viết Migration cho toàn bộ bảng theo thiết kế (Users, Courses, Lessons, Grammar, Cards, Reviews, Quests, etc).
    *   Tạo Eloquent Models với đầy đủ relationships, Casts, Mutators.
    *   Cài đặt FilamentPHP v3.
    *   Tạo Filament Resources cho: Courses, Lessons, GrammarPoints, Cards.
*   **Testing Tasks**:
    *   `Unit`: Test các relationships của Model (VD: `$lesson->cards()`, `$user->stats()`).
    *   `Feature`: Test quyền truy cập Filament (chỉ Admin mới vào được `/admin`).
*   **Deliverable**: Database schema chuẩn chỉnh. Admin panel hoạt động trơn tru để có thể bắt đầu nhập liệu thủ công.

---

## ✅ Phase 3: Data Strategy (Seeding & Audio Generation)
**Mục tiêu**: Tự động hóa việc nạp 2300 từ vựng và tự động sinh Audio bằng Azure TTS.

*   **Backend Tasks**:
    *   Viết Command/Job parse file JSON `jlpt-vocab-list`.
    *   Tích hợp DeepL API (nếu cần batch translate) hoặc dùng file đã dịch sẵn.
    *   Tích hợp Azure Neural TTS API. Tạo `GenerateAudioJob` để chạy ngầm (Queue) sinh file `.mp3`.
    *   Viết Seeder tổng thể `DatabaseSeeder` chạy đúng thứ tự.
*   **Testing Tasks**:
    *   `Unit`: Mock Azure API response để test logic lưu file audio.
    *   `Feature`: Test Command import chạy đúng và không sinh duplicate records.
*   **Deliverable**: Chạy `php artisan db:seed`, DB đầy ắp dữ liệu N5/N4 và hàng ngàn file audio mp3 được sinh ra trong thư mục storage.

---

## ✅ Phase 4: Core SRS Engine (FSRS 4.5) & API
**Mục tiêu**: Hiện thực hóa thuật toán ôn tập ngắt quãng (trái tim của ứng dụng) ở phía Backend.

*   **Backend Tasks**:
    *   Viết `FSRSSchedulerService` với công thức toán học tính stability, difficulty, interval.
    *   Tạo `SubmitCardReviewAction` để xử lý logic update `user_reviews`.
    *   Tạo `UserReviewObserver` (rỗng, chuẩn bị cho XP phase sau).
    *   Viết API Endpoint `POST /api/review` và `GET /api/cards/due` (lấy danh sách thẻ cần ôn).
*   **Testing Tasks (Đặc biệt quan trọng)**:
    *   `Unit`: Nhập mock data cho `FSRSSchedulerService` và assert kết quả `interval_days` trả ra đúng như lý thuyết của FSRS với các điểm số (1, 2, 3, 4).
    *   `Feature`: Test luồng gọi `POST /review` cập nhật đúng state trong database.
*   **Deliverable**: Backend hoàn toàn sẵn sàng xử lý logic tính điểm thẻ và xếp lịch ôn tập.

---

## ✅ Phase 5: Vue Frontend Foundation & Invisible Onboarding
**Mục tiêu**: Dựng UI ôn tập Flashcard và luồng trải nghiệm cho người dùng mới mà không cần đăng ký.

*   **Frontend Tasks**:
    *   Tích hợp thư viện WanaKana.js vào input để auto-type Hiragana.
    *   Code component `ReviewSession.vue`, `FlashCard.vue`.
    *   Code luồng "Invisible Onboarding": Lưu tiến trình tạm vào `localStorage`.
    *   Code popup "Tạo tài khoản để lưu 15 XP".
*   **Backend Tasks**:
    *   Viết `MergeGuestSessionAction` để gộp `localStorage` vào Database khi user đăng ký.
*   **Testing Tasks**:
    *   `Feature`: Test action gộp data: User đăng ký thành công thì trong DB phải có đủ điểm số từ session chơi thử.
*   **Deliverable**: Khách vãng lai vào chơi được flashcard, WanaKana hoạt động, đăng ký xong tiến trình được bảo lưu.

---

## ✅ Phase 6: Interactive Learning UI (Drag & Drop, Artifacts)
**Mục tiêu**: Xây dựng các màn hình tương tác học ngữ pháp và đọc hiểu (Kéo thả).

*   **Frontend Tasks**:
    *   Sử dụng `vuedraggable` để tạo màn hình `DragDropPuzzle.vue`.
    *   Xây dựng màn hình `ArtifactSwipe.vue` (Hiển thị ảnh tĩnh như LINE/Menu và các câu hỏi đi kèm).
*   **Backend Tasks**:
    *   Tạo API trả về bài tập xáo trộn. Tạo endpoint Validate đáp án.
*   **Testing Tasks**:
    *   `Feature`: Backend trả về mảng `blocks_json` không chứa đáp án đúng. Test logic chấm điểm (đúng thứ tự thì pass).
*   **Deliverable**: UI tương tác ngữ pháp kéo-thả cực mượt, không cần F5.

---

## ✅ Phase 7: Gamification Engine (Leaderboard, XP, Streak)
**Mục tiêu**: Giữ chân người dùng bằng game hóa (XP, chuỗi ngày, linh vật, xếp hạng).

*   **Backend Tasks**:
    *   Hoàn thiện `AwardXpAction` trong `UserReviewObserver`.
    *   Tích hợp Redis Sorted Sets cho `LeaderboardService`.
    *   Viết Cron Jobs: `UpdateStreaksCommand` (chạy 00:00 hàng ngày) và `ResetWeeklyLeagueCommand` (chạy thứ Hai hàng tuần).
*   **Frontend Tasks**:
    *   UI Bảng xếp hạng realtime (`WeeklyRanking.vue`).
    *   UI StreakBadge, MascotWidget, XpPopup Animations.
*   **Testing Tasks**:
    *   `Unit`: Test hàm cộng XP.
    *   `Unit`: Chạy thử Cron Job trong Test environment và assert Streak tăng/giảm đúng logic, kể cả khi dùng Bùa đóng băng (Streak Freeze).
*   **Deliverable**: Bảng xếp hạng nhảy điểm ngay khi học xong, Mascot phản ứng theo streak.

---

## ✅ Phase 8: Advanced SRS UX (Leech, Hints, Level-Up)
**Mục tiêu**: Xử lý các điểm mù UX (Blind spots) để tránh người dùng bị nản chí.

*   **Backend Tasks**:
    *   Bổ sung logic "Leech Quarantine" (lapses >= 4) vào `SubmitCardReviewAction`.
    *   Tạo API Manual Override (đánh dấu đã biết, mở khóa leech).
*   **Frontend Tasks**:
    *   Code "Progressive Hint Engine" (Nhấn phím Space để lộ dần gợi ý 3 cấp).
    *   Code "Predictive Level-Up Cue" (Thanh progress nhấp nháy khi gần đủ điểm thăng hạng).
    *   Tạo màn hình `LeechQuarantine.vue`.
*   **Testing Tasks**:
    *   `Feature`: Test thẻ bị trả lời sai 4 lần liên tiếp sẽ tự động bị đổi state thành `is_leech = true` và `is_suspended = true`.
*   **Deliverable**: Trải nghiệm SRS mềm dẻo, người học kiểm soát được tiến độ và không bị ép buộc học từ vựng không nhớ nổi.

---

## ~~Phase 9: Time Tracking (150h) & Monetization (Paywall)~~
**(BỊ HỦY BỎ): Luật cấp chứng nhận 150h tự động không còn được chấp nhận, tính năng này bị loại bỏ hoàn toàn.**

---

## Phase 10: AI Integrations, Monetization & Final Polish
**Mục tiêu**: Hoàn thiện các tính năng còn sót lại (Đọc hiểu, Thanh toán) và đưa "Super App" lên tầm cao mới với OpenAI, chuẩn bị deploy.

*   **Backend Tasks**:
    *   Tích hợp cổng thanh toán (Stripe / VNPay) cho hệ thống Paywall.
    *   Viết API tích hợp OpenAI `gpt-4o-mini` cho tính năng **AI Sensei** (Giải thích ngữ pháp cá nhân hóa).
    *   Thêm Filament Action tự động sinh **Mnemonics** bằng AI.
    *   Tối ưu hóa query N+1, cấu hình Cache.
*   **Frontend Tasks**:
    *   Xây dựng màn hình Đọc hiểu (Reading Comprehension) với component `ArtifactSwipe.vue` (hiển thị ảnh tĩnh và câu hỏi tương tác).
    *   Thêm nút "Hỏi Nihoko" (AI) vào góc các Flashcard khó.
*   **Testing Tasks**:
    *   `Feature`: Test API OpenAI trả về response hợp lệ, test logic cache lại câu trả lời để tiết kiệm tiền.
*   **Deliverable**: Ứng dụng hoàn thiện 100%, sẵn sàng đưa lên server (VPS/Vercel/Forge).

---
> **Hướng dẫn làm việc**: Khi bắt đầu một Phase mới, chỉ cần copy prompt: *"Bắt đầu triển khai Phase X. Hãy đọc lại kiến trúc và liệt kê các file cần tạo/sửa trước khi code"*. Cung cấp lại thư mục `_ai-brain/` để AI lấy Context.

---

## 📝 LƯU TRỮ CÁC TASK TẠM GÁC LẠI (BACKLOGS)

### Tính năng Chế độ Shadowing Toàn diện (Advanced Shadowing Subtitles & Vocab Mining)
*   **Mô tả**: Nâng cấp màn hình Shadowing hiện tại từ một Player tĩnh thành một công cụ học tập tương tác.
*   **Interactive Subtitles**: Thêm phụ đề cuộn theo video (auto-scroll, click-to-seek), hiển thị Kanji, Furigana, và Bản dịch Tiếng Việt.
*   **Vocabulary Mining**: Click vào từ vựng trên phụ đề để xem nghĩa và lưu vào thư mục/bộ bài "Từ vựng Shadowing" để ôn tập theo thuật toán FSRS.
*   **Công cụ rèn luyện**: Tính năng Vòng lặp A-B (A-B Loop Repeat) và Ghi âm & So sánh (Voice Record & Compare).
*   **Yêu cầu Data/Backend**: Cần tạo bảng `shadowing_lessons`, `shadowing_transcripts`. Đặc biệt, tính năng này đòi hỏi một khối lượng **Nhập liệu (Data Entry)** khổng lồ (chuẩn bị file JSON/VTT chi tiết timecode, Kanji, Furigana cho 118 video).

### Hệ thống tính toán ban đầu (Self-Check)
*   *Lưu ý hệ thống*: Điểm ngưỡng (Threshold) đánh dấu Leech ban đầu thiết kế là **4**, nhưng trong quá trình code đã được nâng lên **5** theo yêu cầu UX thực tế để tạo sự khoan dung hơn cho học viên. Dữ liệu này đã được điều chỉnh nhất quán ở backend. Mọi logic trừ XP, tính toán Streak vẫn bám sát đúng thiết kế gốc.
