# Niholo V1 — Chiến lược Dữ liệu Tiếng Nhật (Data Strategy)

> **Cập nhật lần cuối**: 2026-06-05 (v2 — Bổ sung Blind Spot #4: Grammar JF Standard + Cure Dolly, Blind Spot #5: Hybrid Audio)
> **Mục đích**: Quy hoạch toàn bộ nguồn dữ liệu, luồng import và chiến lược sinh audio
> cho nội dung N5/N4 — không nhập tay thủ công toàn bộ.

---

## MỤC LỤC

1. [Tổng quan chiến lược](#1-tổng-quan-chiến-lược)
2. [Nguồn dữ liệu từ vựng & Kanji](#2-nguồn-dữ-liệu-từ-vựng--kanji)
3. [Nguồn câu ví dụ](#3-nguồn-câu-ví-dụ)
4. [Chiến lược Audio (TTS)](#4-chiến-lược-audio-tts)
5. [Nguồn dữ liệu ngữ pháp](#5-nguồn-dữ-liệu-ngữ-pháp)
6. [Ảnh thực tế — Artifact Swipes](#6-ảnh-thực-tế--artifact-swipes)
7. [Luồng Import tổng thể](#7-luồng-import-tổng-thể)
8. [Laravel Seeder Strategy](#8-laravel-seeder-strategy)
9. [Bảng tổng kết Effort](#9-bảng-tổng-kết-effort)

---

## 1. Tổng quan chiến lược

Dữ liệu tiếng Nhật **không nhập tay toàn bộ**. Hệ thống kết hợp 3 lớp:

```
┌─────────────────────────────────────────────────────────┐
│  Lớp 1: AUTO — Import từ open-source datasets            │
│  (~2300 từ vựng N5/N4, câu ví dụ từ Tatoeba)           │
├─────────────────────────────────────────────────────────┤
│  Lớp 2: AUTO — Sinh audio bằng TTS API                  │
│  (Azure Neural TTS / Google Cloud TTS)                  │
├─────────────────────────────────────────────────────────┤
│  Lớp 3: MANUAL (CMS) — Nội dung cần chất lượng cao      │
│  (Grammar points ~43 điểm, Drag-and-drop puzzles,       │
│   Artifact Swipe images, JLPT Boss Arena questions)     │
└─────────────────────────────────────────────────────────┘
```

---

## 2. Nguồn dữ liệu từ vựng & Kanji

### Nguồn chính: `jlpt-vocab-list` (GitHub)

- **URL**: https://github.com/stephenmk/yomichan-jlpt-vocab
- **Nội dung**: N5 (~800 từ), N4 (~1500 từ), đã gắn tag level
- **Format**: JSON / CSV, có sẵn: từ, reading (kana), nghĩa Anh
- **Giấy phép**: Creative Commons — Dùng tự do

```json
// Ví dụ record từ dataset:
{
  "word": "食べる",
  "reading": "たべる",
  "meaning_en": "to eat",
  "jlpt_level": "N5",
  "tags": ["verb", "ichidan"]
}
```

### Nguồn bổ sung: JMdict

- **URL**: https://www.edrdg.org/jmdict/j_jmdict.html
- **Nội dung**: ~170,000 từ, có reading, nghĩa Anh chi tiết
- **Format**: XML (cần parse, convert sang JSON)
- **Dùng khi**: Cần tra nghĩa bổ sung, hoặc Admin tìm từ qua API nội bộ

### Nguồn bổ sung: Jisho.org API

- **URL**: https://jisho.org/api/v1/search/words?keyword=食べる
- **Dùng khi**: FilamentPHP CMS có nút "Tìm từ" → Auto-fill reading + meaning từ Jisho
- **Không dùng** để import hàng loạt (rate limit)

### Mapping sang bảng `cards`

```
jlpt-vocab-list field    →  cards column
─────────────────────────────────────────
word                     →  front_text
reading                  →  reading_kana
meaning_en               →  back_meaning (tiếng Anh)
[cần dịch thêm sang VN]  →  back_meaning (tiếng Việt) *xem bên dưới*
jlpt_level               →  jlpt_level
tags                     →  tags (JSON)
[generate]               →  audio_url
```

> **Nghĩa tiếng Việt**: Dùng **Google Translate API** hoặc **DeepL API** để dịch batch
> `meaning_en → meaning_vi` trong lúc chạy Seeder. DeepL chất lượng cao hơn Google cho tiếng Nhật.
> Free tier DeepL: 500,000 ký tự/tháng — đủ dùng cho 2300 từ.

---

## 3. Nguồn câu ví dụ

### Tatoeba Project

- **URL**: https://tatoeba.org/downloads
- **Nội dung**: Hàng triệu câu song ngữ Nhật-Anh-Việt, do cộng đồng đóng góp
- **Format**: TSV (tab-separated), download trực tiếp
- **Giấy phép**: CC BY 2.0 — Tự do sử dụng có ghi nguồn

**Chiến lược lọc**:
```
1. Download file: jpn_sentences.tsv + links.tsv + eng_sentences.tsv
2. Lọc câu tiếng Nhật chỉ chứa từ vựng N5/N4 (dùng danh sách từ đã import)
3. Join với bản dịch tiếng Anh
4. Lấy ~3-5 câu ví dụ tốt nhất cho mỗi grammar point
5. Import vào bảng example_sentences
```

### JLPT Sensei

- **URL**: https://jlptsensei.com/jlpt-n5-grammar-list/
- **Dùng khi**: Tham khảo câu ví dụ chuẩn cho từng grammar point
- **Cách dùng**: Admin đọc, nhập thủ công qua CMS (số lượng nhỏ ~43 điểm × 3 câu = ~130 câu)

---

## 4. Chiến lược Audio — Hybrid TTS & Real Voice

> **[BLIND SPOT #5 ĐÃ SỬA]**: Không dùng TTS cho toàn bộ. Phân chia rõ:
> - **TTS** → Flashcard từ vựng (2300 file, tự động, rẻ)
> - **Giọng người thật** → Noisy Eavesdropping Quests (hội thoại tự nhiên)

### Lớp 1: Azure Neural TTS — Flashcard Vocabulary

| Option | API | Chi phí | Chất lượng | Dùng cho |
|---|---|---|---|---|
| **Azure Neural TTS** | `ja-JP-NanamiNeural` | Free 500k ký tự/tháng | ⭐⭐⭐⭐⭐ | Flashcard từ vựng ✅ |
| **Google Cloud TTS** | `ja-JP-Wavenet-D` | $4 / 1M ký tự | ⭐⭐⭐⭐ | Backup |
| **VOICEVOX** | Local, open-source | Miễn phí | ⭐⭐⭐ | Dev/testing |

**SSML mẫu** (rate 0.85 cho N5, 1.0 cho N4):
```xml
<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xml:lang="ja-JP">
  <voice name="ja-JP-NanamiNeural">
    <prosody rate="0.85">食べる</prosody>
  </voice>
</speak>
```

**Luồng sinh audio tự động**:
```
Seeder → Import 2300 cards → Dispatch GenerateAudioJob × 2300 (Queue)
    ↓
GenerateAudioJob:
    → Gọi Azure TTS với front_text
    → Lưu: storage/audio/cards/{id}.mp3
    → Lưu thêm: storage/audio/cards/{id}_slow.mp3 (rate=0.7)
    → Cập nhật cards.audio_url
```

---

### Lớp 2: Giọng Người Thật — Noisy Eavesdropping Quests

> **Lý do không dùng TTS cho hội thoại**: TTS thiếu sự ngập ngừng tự nhiên
> (fillers: えーと, あのう), ngữ điệu lên xuống, và tốc độ nói thực tế của người Nhật.
> Điều này làm giảm giá trị luyện nghe thực chiến.

**Nguồn audio hội thoại miễn phí — Japan Foundation**:

| Nguồn | URL | Nội dung | Giấy phép |
|---|---|---|---|
| **Irodori** | https://irodori.jpf.go.jp | Hội thoại N5/N4 theo chủ đề SSW | **Miễn phí, CC** |
| **Marugoto** | https://marugoto.jpf.go.jp | Audio bài học theo chuẩn JF Standard | **Miễn phí** |
| **JLPT Official Sample** | https://www.jlpt.jp/e/samples | Nghe N5/N4 mẫu chính thức | Public |

**Chiến lược xử lý audio thật**:
```
1. Download audio từ Irodori (theo chủ đề Can-do)
2. Cắt nhỏ thành clip 10-20 giây bằng Audacity/ffmpeg
3. Tạo 2 phiên bản:
   → Clean version (phòng thu) — dùng mặc định
   → Noisy version (thêm tiếng ồn nền) — bật/tắt trong app
4. Lưu vào: storage/audio/conversations/{quest_id}.mp3
5. Upload URL vào FilamentPHP CMS gắn với EavesdroppingQuest
```

**Thêm tiếng ồn nền bằng ffmpeg**:
```bash
# Mix audio hội thoại với background noise (cafe, station)
ffmpeg -i conversation.mp3 -i cafe_noise.mp3 \
  -filter_complex "[1:a]volume=0.3[noise];[0:a][noise]amix=inputs=2" \
  conversation_noisy.mp3
```

**Nguồn tiếng ồn nền miễn phí**:
- freesound.org: "japanese cafe ambiance", "train station japan"
- Giấy phép CC0 — dùng tự do thương mại

### Lưu trữ Audio Production

```
Development:  storage/app/public/audio/  (local)
Production:   Cloudflare R2 (rẻ hơn S3 ~10x)
              → audio_url = 'https://cdn.niholo.com/audio/cards/42.mp3'
              → conv_url  = 'https://cdn.niholo.com/audio/conv/quest_5.mp3'
```

---

## 5. Chiến lược Ngữ pháp — JF Standard + Cure Dolly

> **[BLIND SPOT #4 ĐÃ SỬA]**: Không giải thích ngữ pháp theo kiểu sách giáo khoa truyền thống.
> Áp dụng **phương pháp trực quan hóa** (Cure Dolly) + **đặt tên theo Can-do** (JF Standard).

### Nguyên tắc nhập liệu Grammar vào CMS

**❌ KHÔNG làm (kiểu JLPT Sensei cũ)**:
```
Title: ～てください
Meaning: "Please do..."
Formation: V-te form + ください
Explanation: "This grammar pattern is used to make polite requests..."
[Đoạn văn dài 3 đoạn]
```

**✅ PHẢI làm (Cure Dolly Visual + JF Standard)**:
```
Title: ～てください  
Can-do: "Tôi có thể nhờ người khác làm điều gì đó lịch sự"
Visual Model (Admin nhập dạng text/SVG):
    [Chủ thể] → [Động từ て形] → [ください]
    Hình ảnh: "Đoàn tàu" — ください là đích đến, て形 là toa tàu
Core meaning (1 câu): "Xin hãy làm [hành động] cho tôi"
Khác với: ～てもいいです (xin phép), ～なさい (lệnh)
Context: Dùng khi nói chuyện với người lạ, nhân viên, bác sĩ
```

### Đặt tên Bài học theo Can-do (JF Standard)

**❌ KHÔNG dùng**:
- "Bài 1: Giới thiệu bản thân"
- "Lesson 5: Ngữ pháp て形"

**✅ PHẢI dùng** (tên lộ trình theo thực tế sinh sống tại Nhật):

| Lesson | Can-do Statement | Grammar điểm chính |
|---|---|---|
| N5-L1 | "Tôi có thể tự giới thiệu tên và quốc tịch" | ～は～です, ～じゃないです |
| N5-L2 | "Tôi có thể hỏi giá và mua đồ tại cửa hàng" | ～をください, ～はいくらですか |
| N5-L3 | "Tôi có thể nhờ ai đó giúp đỡ đơn giản" | ～てください, ～てもいいですか |
| N5-L4 | "Tôi có thể nói về thói quen hàng ngày" | ～ている, ～ます/ません |
| N5-L5 | "Tôi có thể đặt đồ ăn tại nhà hàng" | ～をお願いします, ～はありますか |
| N4-L1 | "Tôi có thể giải thích lý do đơn giản" | ～から, ～ので |
| N4-L2 | "Tôi có thể nhờ ai đó làm gì cho mình" | ～てもらう, ～てくれる |
| N4-L3 | "Tôi có thể nói về điều kiện giả định" | ～たら, ～ば, ～なら |

### Danh sách Grammar Points N5 + N4

**N5 (~19 điểm)**:
```
～は～です, ～が, ～を, ～に, ～で, ～と,
～てください, ～たい, ～ている, ～ました,
～ませんでした, ～ましょう, ～ませんか,
～から (because), ～まで, ～より,
～も, ～か (question), ～ね/よ
```

**N4 (~24 điểm)**:
```
～てあげる/くれる/もらう, ～させる (causative),
～られる (passive), ～ば (conditional),
～たら, ～なら, ～のに, ～ために,
～ようになる, ～ようにする, ～らしい,
～そうだ, ～はずだ, ～かもしれない,
～だろう, ～ながら, ～てしまう,
～ておく, ～てみる, ～てくる/いく, ～ばかり, ～だけ
```

### Tài liệu tham khảo

| Nguồn | Dùng để | Lưu ý |
|---|---|---|
| **Irodori** (Japan Foundation) | Can-do statements, ngữ cảnh thực tế | Chuẩn JF Standard, miễn phí |
| **Cure Dolly** (YouTube) | Cách giải thích visual, "đoàn tàu" | Tránh copy nguyên văn |
| **Bunpro** | Tham khảo cấu trúc SRS grammar | Không copy nội dung |
| **JLPT Sensei** | Danh sách điểm ngữ pháp cần cover | Chỉ dùng làm checklist |

---

## 6. Ảnh thực tế — Artifact Swipes

### Các loại artifact cần tạo

| Loại | Mô tả | Cách tạo |
|---|---|---|
| Tin nhắn LINE | Hội thoại 3-5 tin giữa 2 người, tiếng Nhật | Figma mockup + LINE frame template |
| Menu Izakaya | Menu nhà hàng Nhật, có giá, món ăn | Thiết kế Canva / Figma, font Noto Sans JP |
| Biển báo ga tàu | Tên ga, số đường, hướng đi | Figma, màu xanh JR East style |
| Biển quảng cáo | Quảng cáo siêu thị, sale, thông báo | Figma, phong cách Nhật Bản |
| Tờ khai hành chính | Form nhập cảnh, đơn đăng ký đơn giản | Figma, giả lập document Nhật |

### Quy trình tạo

```
1. Thiết kế trong Figma (template tái sử dụng được)
2. Export PNG 800×1200px (tỷ lệ mobile-friendly)
3. Upload vào FilamentPHP CMS
4. Lưu URL vào bảng: artifact_images (sẽ thiết kế sau)
5. Admin gắn artifact với câu hỏi đọc hiểu tương ứng
```

### Nguồn ảnh bổ sung

- **Unsplash/Pexels**: Ảnh thực tế Nhật Bản (có bản quyền free)
- **Wikimedia Commons**: Ảnh biển báo thật tại Nhật

---

## 7. Luồng Import tổng thể

```
[BƯỚC 1] Chuẩn bị nguồn (1 ngày)
    → Download jlpt-vocab-list CSV
    → Download Tatoeba TSV
    → Đăng ký Azure TTS (free tier)
    → Đăng ký DeepL API (free tier)

[BƯỚC 2] Chạy Laravel Seeder (tự động ~2-3 giờ)
    → CourseSeeder → LessonSeeder → CardSeeder
    → Batch dịch meaning_vi qua DeepL API
    → Dispatch GenerateAudioJob (Queue workers)

[BƯỚC 3] Queue Workers xử lý (2-4 giờ, chạy ngầm)
    → ~2300 GenerateAudioJob chạy song song (5 workers)
    → File .mp3 được lưu vào storage/
    → cards.audio_url được cập nhật

[BƯỚC 4] Admin dùng CMS nhập nội dung thủ công (3-5 ngày)
    → 43 grammar_points
    → ~130 example_sentences chất lượng cao
    → Drag-and-drop puzzles
    → Artifact Swipe images

[BƯỚC 5] Review & QA
    → Nghe kiểm tra audio
    → Kiểm tra nghĩa tiếng Việt (DeepL không hoàn hảo)
    → Chỉnh sửa qua CMS
```

---

## 8. Laravel Seeder Strategy

### Cấu trúc Seeder

```
database/seeders/
├── DatabaseSeeder.php           ← Orchestrator gọi tất cả
├── RolePermissionSeeder.php     ← Spatie roles: guest, pro, admin
├── CourseSeeder.php             ← 2 courses: N5, N4
├── LessonSeeder.php             ← Lessons theo theme (từ CSV)
├── CardSeeder.php               ← ~2300 cards từ jlpt-vocab-list
├── SampleGrammarSeeder.php      ← 5-10 grammar points mẫu để test UI
└── AdminUserSeeder.php          ← Tạo user admin mặc định

database/data/                   ← Raw data files
├── jlpt_n5_vocab.json
├── jlpt_n4_vocab.json
└── tatoeba_sample.json
```

### Thứ tự chạy (dependency order)

```
RolePermissionSeeder
    ↓
AdminUserSeeder (cần roles)
    ↓
CourseSeeder (N5, N4)
    ↓
LessonSeeder (cần course_id)
    ↓
CardSeeder (cần lesson_id)
    ↓ (dispatch jobs)
GenerateAudioJob × 2300 (async Queue)
    ↓
SampleGrammarSeeder (test data)
```

### Jobs liên quan

```
app/Jobs/
├── GenerateAudioJob.php         ← Gọi Azure TTS, lưu .mp3, update DB
├── TranslateMeaningJob.php      ← Gọi DeepL, update meaning_vi
└── ImportVocabFromJsonJob.php   ← Batch import từ file JSON (có thể dùng thay Seeder)
```

---

## 9. Bảng tổng kết Effort

| Nội dung | Nguồn | Cách lấy | Effort ước tính |
|---|---|---|---|
| ~2300 từ vựng N5/N4 | jlpt-vocab-list (GitHub) | Laravel Seeder tự động | **~2 giờ setup** |
| Nghĩa tiếng Việt | DeepL API | Batch translate trong Seeder | **Tự động** |
| Audio từ vựng (~2300 file) | Azure Neural TTS | Queue Jobs tự động | **~3 giờ chạy ngầm** |
| ~43 điểm ngữ pháp | Irodori + Cure Dolly visual | Admin nhập CMS theo JF Standard | **3-4 ngày** |
| ~130 câu ví dụ | Tatoeba + tự soạn | Admin nhập + chỉnh CMS | **1-2 ngày** |
| ~43 Drag-and-Drop puzzles | Từ example_sentences | Admin tạo qua CMS | **1 ngày** |
| Audio hội thoại (~30 clip) | Irodori / Marugoto (Japan Foundation) | Download + cắt ffmpeg + thêm noise | **2-3 ngày** |
| Ảnh Artifact Swipes (~20 ảnh) | Figma mockup | Designer tạo | **1-2 ngày** |
| JLPT Boss Arena questions | JLPT past papers | Admin nhập CMS | **2-3 ngày** |

> **Tổng**: ~2.5 tuần để có đủ dữ liệu chất lượng cao cho MVP (N5 hoàn chỉnh, N4 một phần).
> Từ vựng và audio TTS là **tự động hoàn toàn**. Audio hội thoại thật là lợi thế cạnh tranh lớn.

---

## PHỤ LỤC: Biến môi trường cần thêm vào `.env`

```env
# Azure TTS
AZURE_TTS_KEY=your_azure_key
AZURE_TTS_REGION=eastasia
AZURE_TTS_VOICE_FEMALE=ja-JP-NanamiNeural
AZURE_TTS_VOICE_MALE=ja-JP-KeitaNeural

# DeepL Translation
DEEPL_API_KEY=your_deepl_key
DEEPL_API_URL=https://api-free.deepl.com/v2/translate

# Audio Storage
AUDIO_DISK=public              # local hoặc s3
AUDIO_CDN_URL=https://cdn.niholo.com

# Jisho API (không cần key, public)
JISHO_API_URL=https://jisho.org/api/v1/search/words
```
