<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
  userStat: {
    type: Object,
    default: () => ({ current_streak: 0, total_xp: 0 }),
  },
  leaderboard: {
    type: Array,
    default: () => [],
  },
  progress: {
    type: Object,
    default: () => ({
      totalCardsN5: 0,
      totalGrammarN5: 0,
      learnedCards: 0,
      learnedGrammar: 0,
    }),
  },
});

// Real data from DB
const streakDays = ref(props.userStat?.current_streak || 0);
const totalXp = ref(props.userStat?.total_xp || 0);

const learnedCards = ref(props.progress.learnedCards);
const totalCardsN5 = ref(props.progress.totalCardsN5);
const learnedGrammar = ref(props.progress.learnedGrammar);
const totalGrammarN5 = ref(props.progress.totalGrammarN5);

const progressN5 = computed(() => {
  const total = props.progress.totalCardsN5 + props.progress.totalGrammarN5;
  if (total === 0) return 0;
  const learned = props.progress.learnedCards + props.progress.learnedGrammar;
  return Math.round((learned / total) * 100);
});

// Level & XP Logic
const currentLevel = computed(() => Math.floor(totalXp.value / 500) + 1);
const currentLevelXp = computed(() => totalXp.value % 500);
const xpToNextLevel = 500;
const levelProgress = computed(() =>
  Math.round((currentLevelXp.value / xpToNextLevel) * 100)
);
const isCloseToLevelUp = computed(() => levelProgress.value >= 85);

const recentActivities = ref([
  {
    id: 1,
    text: "Hoàn thành bài học Kanji số 3",
    time: "2 giờ trước",
    icon: "📝",
  },
  {
    id: 2,
    text: "Đạt chuỗi 15 ngày học liên tiếp",
    time: "Hôm qua",
    icon: "🔥",
  },
  {
    id: 3,
    text: "Hoàn thành bài tập kéo thả Ngữ pháp",
    time: "2 ngày trước",
    icon: "🧩",
  },
]);
</script>

<template>
  <Head title="Tổng quan" />
  <AuthenticatedLayout>
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-6 relative z-10"
    >
      <!-- Top Welcome Area -->
      <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8"
      >
        <div
          class="bg-white p-5 rounded-2xl border-2 border-gray-200 shadow-sm inline-block"
        >
          <h1
            class="text-2xl sm:text-3xl font-black text-gray-800 flex items-center gap-3"
          >
            Chào buổi sáng, {{ $page.props.auth.user.name }}!
            <span class="text-3xl animate-bounce">👋</span>
          </h1>
          <p
            class="text-gray-600 mt-2 text-base font-bold flex flex-wrap items-center gap-2"
          >
            <span class="w-3 h-3 rounded-full bg-[#aaed5a] shadow-sm"></span>
            Bạn đang học:
            <strong
              class="text-[#3d7a4a] bg-[#eef7e6] px-3 py-1 rounded-lg border border-[#c4e8a1]"
              >Khóa học N5 - Ngày 2</strong
            >
          </p>
        </div>
        <div>
          <Link
            :href="route('courses.index')"
            class="inline-flex items-center justify-center px-6 py-4 text-lg font-black text-gray-900 transition-all duration-300 bg-[#aaed5a] rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 group"
          >
            Tiếp tục học ngay
            <svg
              class="w-6 h-6 ml-2 transform group-hover:translate-x-1 transition-transform"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                d="M13 7l5 5m0 0l-5 5m5-5H6"
              ></path>
            </svg>
          </Link>
        </div>
      </div>

      <!-- Bento Box Grid -->
      <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Box 1: Course Progress (Span 8 cols) -->
        <div
          class="md:col-span-8 bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-sm relative overflow-hidden group"
        >
          <div class="flex justify-between items-start mb-4 relative z-10">
            <div>
              <h2
                class="text-xl font-black text-gray-800 uppercase tracking-tight"
              >
                Tiến độ khóa N5
              </h2>
              <p class="text-gray-500 font-bold mt-1 text-sm">
                Chinh phục 600 từ vựng và ngữ pháp
              </p>
            </div>
            <div
              class="bg-[#3d7a4a] text-white px-3 py-1 rounded-xl font-black text-xl shadow-sm hover:-translate-y-1 transition-transform"
            >
              {{ progressN5 }}%
            </div>
          </div>

          <!-- Main Progress Bar -->
          <div
            class="w-full bg-gray-100 rounded-full h-6 mb-6 overflow-hidden relative z-10 shadow-inner"
          >
            <div
              class="bg-[#aaed5a] h-full transition-all duration-1000 relative"
              :style="`width: ${progressN5}%`"
            ></div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
            <div
              class="bg-[#fcfdfa] p-4 rounded-xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform"
            >
              <div
                class="text-gray-700 font-bold mb-1 flex items-center gap-2 text-base"
              >
                <span class="text-xl">📚</span> Từ vựng
              </div>
              <div class="text-3xl font-black text-gray-800">
                {{ learnedCards
                }}<span class="text-lg font-bold text-gray-400 ml-1"
                  >/ {{ totalCardsN5 }}</span
                >
              </div>
            </div>
            <div
              class="bg-[#fcfdfa] p-4 rounded-xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform"
            >
              <div
                class="text-gray-700 font-bold mb-1 flex items-center gap-2 text-base"
              >
                <span class="text-xl">🧩</span> Ngữ pháp
              </div>
              <div class="text-3xl font-black text-gray-800">
                {{ learnedGrammar
                }}<span class="text-lg font-bold text-gray-400 ml-1"
                  >/ {{ totalGrammarN5 }}</span
                >
              </div>
            </div>
            <div
              class="bg-[#fcfdfa] p-4 rounded-xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform"
            >
              <div
                class="text-gray-700 font-bold mb-1 flex items-center gap-2 text-base"
              >
                <span class="text-xl">✍️</span> Hán tự
              </div>
              <div class="text-3xl font-black text-gray-800">
                0<span class="text-lg font-bold text-gray-400 ml-1">/ 120</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Box 2: Streak (Span 4 cols) -->
        <div
          class="md:col-span-4 bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between group transform transition-transform duration-300 hover:-translate-y-1"
        >
          <div
            class="absolute -right-2 -top-2 text-7xl opacity-20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 z-0"
          >
            🔥
          </div>

          <div class="relative z-10">
            <h2
              class="text-xl font-black text-gray-800 uppercase tracking-tight mb-1"
            >
              Lửa Nhiệt Huyết
            </h2>
            <div class="flex items-baseline gap-2 mt-2">
              <span
                class="text-6xl font-black tracking-tighter text-[#e8a820]"
                >{{ streakDays }}</span
              >
              <span class="text-xl font-bold text-gray-600">ngày</span>
            </div>
          </div>

          <div class="relative z-10 mt-4 space-y-3">
            <div
              class="flex items-center gap-2 text-2xl font-black text-gray-800"
            >
              <span class="text-yellow-400">⚡</span> {{ totalXp }} XP
            </div>
            <p
              class="text-sm font-medium text-gray-600 bg-orange-50 rounded-xl p-3 leading-relaxed"
            >
              Tuyệt vời! Bạn đang giữ chuỗi học rất tốt. Tiếp tục phát huy hôm
              nay nhé.
            </p>
          </div>
        </div>

        <!-- Box 3: FSRS Vault (Span 4 cols) -->
        <div
          class="md:col-span-4 bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col hover:-translate-y-1 transition-transform duration-300"
        >
          <div class="flex items-center gap-4 mb-4">
            <div
              class="w-12 h-12 rounded-xl bg-[#eef7e6] flex items-center justify-center text-2xl border border-[#c4e8a1]"
            >
              🧠
            </div>
            <div>
              <h3
                class="font-black text-gray-800 text-xl uppercase tracking-tight"
              >
                Kho Thẻ FSRS
              </h3>
              <p class="text-sm font-medium text-gray-500">
                Chu kỳ lặp lại ngắt quãng
              </p>
            </div>
          </div>

          <div class="flex-1 flex flex-col justify-center gap-3 mb-4">
            <div
              class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex justify-between items-center hover:-translate-x-1 transition-transform"
            >
              <span class="text-gray-700 font-bold text-sm"
                >Cần ôn hôm nay</span
              >
              <span class="text-2xl font-black text-[#3d7a4a]">24</span>
            </div>
            <div
              class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex justify-between items-center hover:-translate-x-1 transition-transform"
            >
              <span
                class="text-gray-700 font-bold text-sm flex items-center gap-2"
              >
                Thẻ cách ly
                <span class="flex h-3 w-3 relative">
                  <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"
                  ></span>
                  <span
                    class="relative inline-flex rounded-full h-3 w-3 bg-red-500"
                  ></span>
                </span>
              </span>
              <span class="text-2xl font-black text-red-500">3</span>
            </div>
          </div>

          <Link
            :href="route('vault.index')"
            class="w-full py-3 bg-[#fcfdfa] text-[#3d7a4a] border border-[#c4e8a1] rounded-xl font-bold text-sm text-center flex justify-center items-center gap-2 hover:bg-[#eef7e6] transition-all"
          >
            Quản lý thẻ
            <svg
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M14 5l7 7m0 0l-7 7m7-7H3"
              ></path>
            </svg>
          </Link>
        </div>

        <!-- Box 4: XP & Level (Span 8 cols) -->
        <div
          class="md:col-span-8 bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-sm relative overflow-hidden group"
        >
          <div
            class="flex flex-col sm:flex-row gap-6 items-center h-full relative z-10"
          >
            <div class="flex-1 w-full relative">
              <div class="flex justify-between items-center mb-4">
                <h3
                  class="font-black text-gray-800 text-2xl flex items-center gap-2 uppercase tracking-tight"
                >
                  Cấp độ {{ currentLevel }}
                </h3>
                <span
                  class="bg-[#f0f9ff] text-[#0369a1] px-3 py-1 rounded-xl text-sm font-bold border border-[#bae6fd]"
                >
                  {{ totalXp }} XP Tổng
                </span>
              </div>

              <div
                class="w-full bg-gray-100 rounded-full h-6 shadow-inner mb-3 relative overflow-hidden"
              >
                <div
                  class="bg-[#3d7a4a] h-full transition-all duration-1000 relative"
                  :style="`width: ${levelProgress}%`"
                ></div>
              </div>

              <div
                class="flex justify-between text-sm text-gray-500 font-medium"
              >
                <span>{{ currentLevelXp }} XP</span>
                <span>Còn {{ xpToNextLevel - currentLevelXp }} XP nữa</span>
              </div>
            </div>

            <div
              class="sm:w-64 w-full bg-gray-50 border border-gray-100 rounded-2xl p-5 flex flex-col items-center text-center hover:-translate-y-1 transition-transform"
            >
              <div
                class="text-5xl mb-2 hover:scale-110 transition-transform cursor-pointer"
              >
                🏆
              </div>
              <h4
                class="font-bold text-gray-800 text-lg uppercase tracking-tight"
              >
                Bảng Xếp Hạng
              </h4>
              <p
                class="text-xs font-medium text-gray-500 mt-1 mb-4 leading-relaxed"
              >
                Tuần này chưa có điểm. Hãy là người đầu tiên ghi điểm!
              </p>
              <Link
                :href="route('leaderboard.index')"
                class="inline-flex items-center justify-center w-full gap-2 text-[#3d7a4a] bg-[#eef7e6] px-4 py-2 border border-[#c4e8a1] rounded-xl font-bold text-sm hover:bg-[#aaed5a] hover:text-gray-900 transition-all group/link"
              >
                Xem Leaderboard
                <span
                  class="transform group-hover/link:translate-x-1 transition-transform"
                  >&rarr;</span
                >
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>
@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(200%);
  }
}
</style>
