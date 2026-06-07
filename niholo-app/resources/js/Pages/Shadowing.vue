<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// ──────────────────────────────────────────────
//  PLAYLIST DATA
// ──────────────────────────────────────────────
const realVideoIds = [
  "-yjL-sQwJpw",
  "tet1dqZS7F4",
  "Xn2HZ6yW8i8",
  "NpBD0qJIAh8",
  "dpNq3dgy2r8",
  "kKfamEPon7Y",
  "KUBcMezRkTw",
  "oTZN2xxp7UY",
  "50C4Rrw_FJU",
  "UbriqBNn9YQ",
  "Jg51TlImAU4",
  "nqT_xBp7tIk",
  "XIpNLbF8nUA",
  "hQ85jDPPFH4",
  "njFwwRleqZM",
  "8cok3QoFrWw",
  "GSsAUgELVPU",
  "tzOkeCc2ub8",
  "j9EshGHeiHI",
  "g_mdwmXUyvE",
  "vIGLP_hfU2g",
  "0Mm-8a3MxzI",
  "zsfNb2zFhn0",
  "gNJ21M7arY0",
  "_79Swyim0QM",
  "mQQLncop6lk",
  "1oW2dgSyMY0",
  "6NKFPs_ZzO0",
  "6GItxYT7jOw",
  "Vijhx3yowaQ",
  "A9OKTJpGVIw",
  "Tcc2A5gbi2U",
  "b-kWn3Icuos",
  "Gf8tz4pVLnk",
  "L2LIZlLCJHg",
  "BZFPftNSh2Y",
  "nYw_MRCKyg4",
  "xC9gP0jUoik",
  "fSLrpaEdd2A",
  "593vuQhY5-A",
  "YK6ZZ55qG5s",
  "0oD_zZoXLvI",
  "f4V7y5Hz4XY",
  "VqGRsru49sU",
  "N0VwWGVNq84",
  "VmzdeCx27ug",
  "kbH2ofombro",
  "rBkoGbUpE1w",
  "OaTDiqlPQDI",
  "bVZXVaz3ESg",
  "XjO52zDB9fc",
  "7t6S0egV8So",
  "YHFnS941rwQ",
  "hvyoXpGruq8",
  "_KdjfCwd32M",
  "651VxPFWRzs",
  "TFDUgfpAzWc",
  "9Bbb6Pi1ofM",
  "SiJk6-ERrs4",
  "WTOQjxWh6u4",
  "eVTspLmkHd4",
  "yTvkjJXy6Nc",
  "9xS0VQ7DjEo",
  "omYV3uHqQQA",
  "yc38-tzX0a0",
  "uHX3AoprnTw",
  "AV5HlWRrEc8",
  "ZjSwx3KBHC4",
  "s2ZfV4gUk8I",
  "VMCRUVmTIvM",
  "IEwZdLuONtE",
  "P2mIDSuXEiw",
  "RUhM5WGS8Rc",
  "GyEM8nGMfHE",
  "mKHFQkyR5tk",
  "t8nbNLcNnt8",
  "drfytiIrcbU",
  "wzb4JO7fYc8",
  "WOlYone5z-8",
  "QGD2E98tIto",
  "GZATxbQzQUI",
  "AzydD3VopkY",
  "hamj6-ChX-g",
  "HLUAA3gb4qc",
  "T4nUnq-iRYg",
  "PHJ8ZVLVYbw",
  "iWS-QRzCVNY",
  "D7FvzQv7ook",
  "TqWoXDmYbO0",
  "_tEgI8EDTK8",
  "0SasSGHmwys",
  "gEz2-WzOZvs",
  "Mj61_Cb77HE",
  "4e87m0tUS-4",
  "hj45W6l-e80",
  "1-UeLY7vk6A",
  "cPfy_lZZcNo",
  "P2pXL8vmXck",
  "-hPmghqZ4ZM",
  "3jOu9JrPNCA",
];

const generateLessons = (total = 118) => {
  const list = [];
  for (let i = 1; i <= total; i++) {
    list.push({
      id: i,
      videoId: realVideoIds[i - 1] || "",
      title: `Bài ${i} – Hội thoại Kaiwa`,
      subtitle: i === 1 ? "Chào hỏi cơ bản" : "Giao tiếp đời sống",
      level: "N5",
      done: false,
    });
  }
  return list;
};

const lessons = ref(generateLessons());
const currentLesson = ref(lessons.value[0]);

const selectLesson = (lesson) => {
  currentLesson.value = lesson;
  if (player && typeof player.loadVideoById === "function") {
    player.loadVideoById(lesson.videoId);
    currentTime.value = 0;
    isPlaying.value = true;
  }
};

const markDone = (lesson) => {
  lesson.done = !lesson.done;
};
const doneCount = computed(() => lessons.value.filter((l) => l.done).length);
const progressPct = computed(() =>
  Math.round((doneCount.value / lessons.value.length) * 100)
);

// ──────────────────────────────────────────────
//  YOUTUBE IFRAME API
// ──────────────────────────────────────────────
let player = null;
let pollTimer = null;

const isPlaying = ref(false);
const currentTime = ref(0);
const duration = ref(0);
const playbackRate = ref(1);
const isReady = ref(false);

const rates = [0.5, 0.75, 1, 1.25, 1.5];

const fmtTime = (s) => {
  if (!s || isNaN(s)) return "0:00";
  const m = Math.floor(s / 60);
  const sec = Math.floor(s % 60);
  return `${m}:${sec.toString().padStart(2, "0")}`;
};

const progressDisplay = computed(() => {
  if (!duration.value) return 0;
  return (currentTime.value / duration.value) * 100;
});

const initPlayer = () => {
  if (typeof window === "undefined" || !window.YT) return;
  player = new window.YT.Player("yt-focus-player", {
    videoId: currentLesson.value.videoId,
    playerVars: {
      autoplay: 1,
      controls: 0,
      disablekb: 1,
      fs: 0,
      iv_load_policy: 3,
      modestbranding: 1,
      rel: 0,
      showinfo: 0,
      playsinline: 1,
    },
    events: {
      onReady: (e) => {
        isReady.value = true;
        duration.value = e.target.getDuration();
        e.target.playVideo();
        isPlaying.value = true;
        startPoll();
      },
      onStateChange: (e) => {
        if (e.data === 1) {
          isPlaying.value = true;
          startPoll();
        } else {
          isPlaying.value = false;
          stopPoll();
        }
        if (e.data === 0) {
          currentLesson.value.done = true;
        }
      },
    },
  });
};

const startPoll = () => {
  stopPoll();
  pollTimer = setInterval(() => {
    if (player && typeof player.getCurrentTime === "function") {
      currentTime.value = player.getCurrentTime() || 0;
      duration.value = player.getDuration() || 0;
    }
  }, 500);
};

const stopPoll = () => {
  if (pollTimer) {
    clearInterval(pollTimer);
    pollTimer = null;
  }
};

const togglePlay = () => {
  if (!player) return;
  if (isPlaying.value) {
    player.pauseVideo();
  } else {
    player.playVideo();
  }
};

const seek = (e) => {
  if (!player || !duration.value) return;
  const rect = e.currentTarget.getBoundingClientRect();
  const ratio = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
  player.seekTo(ratio * duration.value, true);
  currentTime.value = ratio * duration.value;
};

const setRate = (r) => {
  playbackRate.value = r;
  if (player) player.setPlaybackRate(r);
};

const skip = (secs) => {
  if (!player) return;
  const t = Math.max(0, Math.min(duration.value, currentTime.value + secs));
  player.seekTo(t, true);
  currentTime.value = t;
};

onMounted(() => {
  if (window.YT && window.YT.Player) {
    initPlayer();
    return;
  }
  const tag = document.createElement("script");
  tag.src = "https://www.youtube.com/iframe_api";
  document.head.appendChild(tag);
  window.onYouTubeIframeAPIReady = initPlayer;
});

onUnmounted(() => {
  stopPoll();
  if (player) {
    player.destroy();
    player = null;
  }
});

const tips = [
  "🎯 Nghe → Lặp lại → Ghi âm → So sánh",
  "🔁 Nghe mỗi đoạn 3-5 lần trước khi lặp",
  "🐢 Dùng 0.75x để bắt kịp tốc độ nói",
  "📝 Ghi lại các từ khó phát âm",
  "💪 10-20 phút mỗi ngày tốt hơn 2 tiếng/tuần",
];
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Shadowing – Luyện Phát Âm Tiếng Nhật" />

    <div class="p-6 max-w-7xl mx-auto">
      <!-- PAGE HEADER -->
      <div
        class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4"
      >
        <div>
          <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-100 border-2 border-black text-purple-900 font-black text-xs mb-2 shadow-[2px_2px_0px_rgba(0,0,0,1)]"
          >
            🎤 SHADOWING
          </div>
          <h1 class="text-3xl md:text-4xl font-black uppercase">
            Luyện Shadowing
          </h1>
          <p class="font-bold text-gray-600 mt-1">
            Nghe – Lặp lại theo người bản xứ để luyện phát âm chuẩn
          </p>
        </div>
        <div
          class="bg-white border-4 border-black rounded-2xl p-4 shadow-[6px_6px_0px_rgba(0,0,0,1)] min-w-[200px]"
        >
          <div class="flex justify-between items-center mb-2">
            <span class="font-black text-sm">Tiến độ</span>
            <span class="font-black text-lg text-purple-700"
              >{{ doneCount }}/{{ lessons.length }}</span
            >
          </div>
          <div
            class="w-full h-4 bg-gray-200 rounded-full border-2 border-black overflow-hidden"
          >
            <div
              class="h-full bg-purple-400 rounded-full transition-all duration-500"
              :style="{ width: progressPct + '%' }"
            ></div>
          </div>
          <div class="text-center font-bold text-sm mt-1 text-gray-600">
            {{ progressPct }}% hoàn thành
          </div>
        </div>
      </div>

      <!-- MAIN LAYOUT -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT: Focus Player -->
        <div class="lg:col-span-2 flex flex-col gap-4">
          <!-- ═══ FOCUS VIDEO PLAYER ═══ -->
          <div
            class="bg-black border-4 border-black rounded-3xl overflow-hidden shadow-[8px_8px_0px_rgba(0,0,0,1)]"
          >
            <!-- YouTube renders here, pointer-events: none hides all YT UI -->
            <div class="relative aspect-video bg-black">
              <div
                id="yt-focus-player"
                class="absolute inset-0 w-full h-full pointer-events-none"
              ></div>

              <!-- Click overlay – intercepts clicks & shows pause icon -->
              <div
                class="absolute inset-0 z-10 cursor-pointer"
                @click="togglePlay"
              >
                <transition name="fade">
                  <div
                    v-if="!isPlaying && isReady"
                    class="absolute inset-0 flex items-center justify-center bg-black/30"
                  >
                    <div
                      class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/50"
                    >
                      <svg
                        class="w-10 h-10 text-white ml-1"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path d="M8 5v14l11-7z" />
                      </svg>
                    </div>
                  </div>
                </transition>
              </div>
            </div>

            <!-- ═══ CUSTOM MINIMAL CONTROL BAR ═══ -->
            <div class="bg-gray-950 px-5 py-4 flex flex-col gap-3">
              <!-- Scrubber / Timeline -->
              <div class="flex items-center gap-3">
                <span class="text-white/60 font-mono text-xs min-w-[38px]">{{
                  fmtTime(currentTime)
                }}</span>

                <div
                  class="flex-1 h-2 bg-white/10 rounded-full cursor-pointer group relative"
                  @click="seek"
                >
                  <div
                    class="absolute inset-y-0 left-0 bg-purple-500 rounded-full transition-all"
                    :style="{ width: progressDisplay + '%' }"
                  ></div>
                  <div
                    class="absolute top-1/2 -translate-y-1/2 w-3.5 h-3.5 bg-white rounded-full border-2 border-purple-500 shadow opacity-0 group-hover:opacity-100 transition-opacity"
                    :style="{ left: `calc(${progressDisplay}% - 7px)` }"
                  ></div>
                </div>

                <span
                  class="text-white/60 font-mono text-xs min-w-[38px] text-right"
                  >{{ fmtTime(duration) }}</span
                >
              </div>

              <!-- Controls -->
              <div class="flex items-center justify-between">
                <!-- Play + Skip -->
                <div class="flex items-center gap-2">
                  <button
                    @click="skip(-10)"
                    title="Lùi 10 giây"
                    class="text-white/60 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors"
                  >
                    <svg
                      class="w-5 h-5"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                    >
                      <path
                        d="M11.99 5V1l-5 5 5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6h-2c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"
                      />
                      <text
                        x="8"
                        y="15.5"
                        font-size="6"
                        fill="currentColor"
                        font-weight="bold"
                      >
                        10
                      </text>
                    </svg>
                  </button>

                  <button
                    @click="togglePlay"
                    class="w-11 h-11 bg-purple-600 hover:bg-purple-500 text-white rounded-full flex items-center justify-center transition-all shadow-[0_0_16px_rgba(147,51,234,0.5)] hover:shadow-[0_0_24px_rgba(147,51,234,0.7)]"
                  >
                    <svg
                      v-if="!isPlaying"
                      class="w-6 h-6 ml-0.5"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path d="M8 5v14l11-7z" />
                    </svg>
                    <svg
                      v-else
                      class="w-5 h-5"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                  </button>

                  <button
                    @click="skip(10)"
                    title="Tiến 10 giây"
                    class="text-white/60 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors"
                  >
                    <svg
                      class="w-5 h-5"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                    >
                      <path
                        d="M12.01 5V1l5 5-5 5V7c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6h2c0 4.42-3.58 8-8 8s-8-3.58-8-8 3.58-8 8-8z"
                      />
                      <text
                        x="8"
                        y="15.5"
                        font-size="6"
                        fill="currentColor"
                        font-weight="bold"
                      >
                        10
                      </text>
                    </svg>
                  </button>
                </div>

                <!-- Speed + Done -->
                <div class="flex items-center gap-3">
                  <!-- Speed -->
                  <div class="flex items-center gap-1">
                    <button
                      v-for="r in rates"
                      :key="r"
                      @click="setRate(r)"
                      class="px-2 py-1 rounded-lg text-xs font-black transition-all"
                      :class="
                        playbackRate === r
                          ? 'bg-purple-600 text-white'
                          : 'text-white/50 hover:text-white hover:bg-white/10'
                      "
                    >
                      {{ r }}x
                    </button>
                  </div>

                  <!-- Mark done -->
                  <button
                    @click="markDone(currentLesson)"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border-2 font-black text-xs transition-all"
                    :class="
                      currentLesson.done
                        ? 'bg-[#aaed5a] border-[#aaed5a] text-black'
                        : 'border-white/30 text-white/60 hover:border-white/60 hover:text-white'
                    "
                  >
                    <svg
                      class="w-3.5 h-3.5"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="3"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                    {{ currentLesson.done ? "Đã học" : "Xong" }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Lesson title -->
          <div
            class="bg-white border-4 border-black rounded-2xl p-4 shadow-[6px_6px_0px_rgba(0,0,0,1)] flex items-center justify-between"
          >
            <div>
              <div class="flex items-center gap-2 mb-0.5">
                <span
                  class="px-2 py-0.5 bg-purple-200 border-2 border-black rounded-lg font-black text-xs"
                  >{{ currentLesson.level }}</span
                >
              </div>
              <h2 class="text-xl font-black">{{ currentLesson.title }}</h2>
              <p class="font-bold text-gray-600 text-sm">
                {{ currentLesson.subtitle }}
              </p>
            </div>
            <a
              href="https://www.youtube.com/playlist?list=PL3WaVMwGCmNrlhVjNAYMB1sR1X3o_89Ty"
              target="_blank"
              class="shrink-0 flex items-center gap-2 px-4 py-2 bg-red-600 text-white border-4 border-black rounded-full font-black text-sm shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all"
            >
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M21.582 6.186a2.665 2.665 0 0 0-1.875-1.884C18.053 3.86 12 3.86 12 3.86s-6.053 0-7.707.442a2.665 2.665 0 0 0-1.875 1.884C2 7.854 2 12 2 12s0 4.146.418 5.814a2.665 2.665 0 0 0 1.875 1.884C5.947 20.14 12 20.14 12 20.14s6.053 0 7.707-.442a2.665 2.665 0 0 0 1.875-1.884C22 16.146 22 12 22 12s0-4.146-.418-5.814zM9.917 15.352V8.648L15.683 12l-5.766 3.352z"
                />
              </svg>
              YouTube
            </a>
          </div>

          <!-- Tips -->
          <div
            class="bg-purple-50 border-4 border-black rounded-2xl p-5 shadow-[6px_6px_0px_rgba(0,0,0,1)]"
          >
            <h3 class="font-black text-lg mb-3 uppercase">
              💡 Tips Shadowing Hiệu Quả
            </h3>
            <ul class="space-y-2">
              <li
                v-for="tip in tips"
                :key="tip"
                class="font-bold text-gray-800"
              >
                {{ tip }}
              </li>
            </ul>
          </div>
        </div>

        <!-- RIGHT: Playlist -->
        <div class="flex flex-col gap-4">
          <div
            class="bg-purple-600 text-white border-4 border-black rounded-2xl p-4 shadow-[6px_6px_0px_rgba(0,0,0,1)]"
          >
            <div class="text-2xl mb-1">🎌</div>
            <div class="font-black text-lg">Danh Sách Bài</div>
            <div class="font-bold text-purple-200 text-sm">
              {{ lessons.length }} bài · N5 Minna no Nihongo
            </div>
          </div>

          <div
            class="bg-white border-4 border-black rounded-2xl overflow-hidden shadow-[6px_6px_0px_rgba(0,0,0,1)]"
          >
            <div class="max-h-[640px] overflow-y-auto">
              <button
                v-for="(lesson, index) in lessons"
                :key="lesson.id"
                @click="selectLesson(lesson)"
                class="w-full flex items-center gap-3 p-3.5 text-left border-b-2 border-gray-100 transition-all hover:bg-purple-50 last:border-b-0"
                :class="
                  currentLesson.id === lesson.id
                    ? 'bg-purple-100 border-l-4 border-l-purple-600'
                    : ''
                "
              >
                <div
                  class="w-8 h-8 shrink-0 rounded-full border-2 border-black flex items-center justify-center font-black text-xs transition-colors"
                  :class="
                    lesson.done
                      ? 'bg-[#aaed5a]'
                      : currentLesson.id === lesson.id
                      ? 'bg-purple-600 text-white'
                      : 'bg-gray-100'
                  "
                >
                  <span v-if="lesson.done">✓</span>
                  <span v-else>{{ index + 1 }}</span>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="font-black text-sm truncate">
                    {{ lesson.title }}
                  </div>
                  <div class="font-bold text-xs text-gray-500 truncate">
                    {{ lesson.subtitle }}
                  </div>
                </div>
                <div
                  v-if="currentLesson.id === lesson.id && isPlaying"
                  class="shrink-0 flex gap-0.5 items-end h-5"
                >
                  <span
                    class="w-1 bg-purple-600 rounded-full animate-bounce"
                    style="height: 16px; animation-delay: 0ms"
                  ></span>
                  <span
                    class="w-1 bg-purple-600 rounded-full animate-bounce"
                    style="height: 10px; animation-delay: 150ms"
                  ></span>
                  <span
                    class="w-1 bg-purple-600 rounded-full animate-bounce"
                    style="height: 16px; animation-delay: 300ms"
                  ></span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
