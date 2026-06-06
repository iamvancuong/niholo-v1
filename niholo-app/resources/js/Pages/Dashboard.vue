<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    userStat: {
        type: Object,
        default: () => ({ current_streak: 0, total_xp: 0 })
    },
    leaderboard: {
        type: Array,
        default: () => []
    },
    progress: {
        type: Object,
        default: () => ({
            totalCardsN5: 0,
            totalGrammarN5: 0,
            learnedCards: 0,
            learnedGrammar: 0
        })
    }
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
const levelProgress = computed(() => Math.round((currentLevelXp.value / xpToNextLevel) * 100));
const isCloseToLevelUp = computed(() => levelProgress.value >= 85);

const recentActivities = ref([
    { id: 1, text: 'Hoàn thành bài học Kanji số 3', time: '2 giờ trước', icon: '📝' },
    { id: 2, text: 'Đạt chuỗi 15 ngày học liên tiếp', time: 'Hôm qua', icon: '🔥' },
    { id: 3, text: 'Hoàn thành bài tập kéo thả Ngữ pháp', time: '2 ngày trước', icon: '🧩' },
]);

</script>

<template>
    <Head title="Tổng quan" />
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 pt-8 relative z-10">
            
            <!-- Top Welcome Area -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                        Chào buổi sáng, {{ $page.props.auth.user.name }}! <span class="text-3xl">👋</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-base font-medium flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                        Bạn đang dừng lại ở: <strong class="text-indigo-600 dark:text-indigo-400">Khóa học N5 - Ngày 2</strong>
                    </p>
                </div>
                <div>
                    <Link :href="route('courses.index')" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-300 bg-gradient-to-r from-indigo-600 to-pink-500 rounded-2xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-[1.02] active:scale-95 group">
                        Tiếp tục học ngay
                        <svg class="w-6 h-6 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </Link>
                </div>
            </div>

            <!-- Bento Box Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <!-- Box 1: Course Progress (Span 8 cols) -->
                <div class="md:col-span-8 bg-white dark:bg-gray-800/90 backdrop-blur-xl border border-gray-100 dark:border-gray-700/50 rounded-3xl p-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500 rounded-full blur-3xl opacity-5 group-hover:opacity-10 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Tiến độ khóa N5</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Chinh phục 600 từ vựng và ngữ pháp</p>
                        </div>
                        <div class="bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-xl font-bold text-lg border border-indigo-100 dark:border-indigo-500/30 shadow-inner">
                            {{ progressN5 }}%
                        </div>
                    </div>

                    <!-- Main Progress Bar -->
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-5 mb-8 overflow-hidden relative shadow-inner z-10">
                        <div class="bg-gradient-to-r from-indigo-500 to-pink-500 h-full rounded-full transition-all duration-1000 relative" :style="`width: ${progressN5}%`">
                            <div class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_2s_infinite] -skew-x-12"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
                        <div class="bg-gray-50 dark:bg-gray-700/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-600/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2 flex items-center gap-2">
                                <span class="text-lg">📚</span> Thẻ Từ vựng
                            </div>
                            <div class="text-3xl font-black text-gray-800 dark:text-white">{{ learnedCards }}<span class="text-lg font-bold text-gray-400 ml-1">/ {{ totalCardsN5 }}</span></div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-600/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2 flex items-center gap-2">
                                <span class="text-lg">🧩</span> Mẫu Ngữ pháp
                            </div>
                            <div class="text-3xl font-black text-gray-800 dark:text-white">{{ learnedGrammar }}<span class="text-lg font-bold text-gray-400 ml-1">/ {{ totalGrammarN5 }}</span></div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-600/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2 flex items-center gap-2">
                                <span class="text-lg">✍️</span> Chữ Hán tự
                            </div>
                            <div class="text-3xl font-black text-gray-800 dark:text-white">0<span class="text-lg font-bold text-gray-400 ml-1">/ 120</span></div>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Streak (Span 4 cols) -->
                <div class="md:col-span-4 bg-gradient-to-br from-orange-400 via-rose-500 to-pink-600 rounded-3xl p-8 shadow-lg shadow-orange-500/20 text-white relative overflow-hidden flex flex-col justify-between group transform transition-transform duration-300 hover:scale-[1.03]">
                    <div class="absolute -right-8 -top-8 text-9xl opacity-20 filter drop-shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">🔥</div>
                    
                    <div class="relative z-10">
                        <h2 class="text-lg font-medium opacity-90 mb-1 tracking-wide">Lửa Nhiệt Huyết</h2>
                        <div class="flex items-baseline gap-2 mt-2">
                            <span class="text-7xl font-black tracking-tighter drop-shadow-md">{{ streakDays }}</span>
                            <span class="text-xl font-bold opacity-90">ngày</span>
                        </div>
                    </div>
                    
                    <div class="relative z-10 mt-6 space-y-3">
                        <div class="flex items-center gap-2 text-2xl font-black text-yellow-300 drop-shadow-md">
                            <span>⚡</span> {{ totalXp }} XP
                        </div>
                        <p class="text-sm font-medium text-orange-50 bg-white/20 backdrop-blur-sm rounded-xl p-3 border border-white/20 leading-relaxed">
                            Bạn đang giữ chuỗi học rất tốt! Tiếp tục phát huy hôm nay nhé.
                        </p>
                    </div>
                </div>

                <!-- Box 3: FSRS Vault (Span 4 cols) -->
                <div class="md:col-span-4 bg-white dark:bg-gray-800/90 backdrop-blur-xl border border-gray-100 dark:border-gray-700/50 rounded-3xl p-8 shadow-sm hover:shadow-md transition-shadow flex flex-col">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl shadow-inner border border-indigo-100 dark:border-indigo-800/50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Kho Thẻ FSRS</h3>
                            <p class="text-sm text-gray-500">Chu kỳ lặp lại ngắt quãng</p>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-center gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700/40 rounded-2xl p-4 flex justify-between items-center border border-gray-100 dark:border-gray-600/50">
                            <span class="text-gray-600 dark:text-gray-300 font-medium">Cần ôn hôm nay</span>
                            <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 drop-shadow-sm">24</span>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-4 flex justify-between items-center border border-red-100 dark:border-red-800/30">
                            <span class="text-red-600 dark:text-red-400 font-medium flex items-center gap-2">
                                Thẻ cách ly
                                <span class="flex h-3 w-3 relative">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                            </span>
                            <span class="text-2xl font-bold text-red-600 dark:text-red-400">3</span>
                        </div>
                    </div>

                    <Link :href="route('vault.index')" class="w-full py-3.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-xl font-bold text-center transition flex justify-center items-center gap-2">
                        Quản lý thẻ <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </Link>
                </div>

                <!-- Box 4: XP & Level (Span 8 cols) -->
                <div class="md:col-span-8 bg-white dark:bg-gray-800/90 backdrop-blur-xl border border-gray-100 dark:border-gray-700/50 rounded-3xl p-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-500 rounded-full blur-3xl opacity-5 pointer-events-none group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <div class="flex flex-col sm:flex-row gap-8 items-center h-full relative z-10">
                        <div class="flex-1 w-full relative">
                            <div class="flex justify-between items-center mb-5">
                                <h3 class="font-bold text-gray-800 dark:text-white text-xl flex items-center gap-2">
                                    Cấp độ {{ currentLevel }}
                                </h3>
                                <span class="bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 px-4 py-1.5 rounded-full text-sm font-bold border border-emerald-100 dark:border-emerald-500/30">
                                    {{ totalXp }} XP Tổng
                                </span>
                            </div>
                            
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-5 overflow-hidden shadow-inner mb-3 relative">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000 relative" :style="`width: ${levelProgress}%`"></div>
                            </div>
                            
                            <div class="flex justify-between text-sm text-gray-500 font-medium">
                                <span>{{ currentLevelXp }} XP</span>
                                <span>Còn {{ xpToNextLevel - currentLevelXp }} XP để thăng cấp</span>
                            </div>
                        </div>

                        <div class="sm:w-72 w-full bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/30 rounded-2xl p-6 flex flex-col items-center text-center shadow-sm">
                            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-800/50 rounded-full flex items-center justify-center text-emerald-600 dark:text-emerald-300 text-3xl mb-4 shadow-inner">
                                🏆
                            </div>
                            <h4 class="font-bold text-gray-800 dark:text-white text-lg">Bảng Xếp Hạng</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4 leading-relaxed">Tuần này chưa có điểm. Hãy là người đầu tiên ghi điểm!</p>
                            <Link :href="route('leaderboard.index')" class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 text-sm font-bold hover:text-emerald-700 transition group/link">
                                Xem Leaderboard <span class="transform group-hover/link:translate-x-1 transition-transform">&rarr;</span>
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
            

        </div>

        <!-- Background Decoration (Centered with Kanji) -->
        <div class="fixed bottom-0 inset-x-0 h-[300px] md:h-[400px] pointer-events-none z-0 overflow-hidden">
            <!-- Floating Kanji Background -->
            <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.02] flex items-center justify-center text-[6rem] md:text-[10rem] font-black text-gray-900 dark:text-white select-none whitespace-nowrap overflow-hidden leading-none tracking-[0.5em] gap-12 md:gap-24" style="writing-mode: vertical-rl;">
                <span class="mt-10">日本語</span>
                <span class="mb-32">能力</span>
                <span class="mt-20">学習</span>
                <span class="mb-10">進歩</span>
            </div>
            
            <!-- Fuji Image -->
            <div class="absolute bottom-0 inset-x-0 w-full h-full bg-no-repeat bg-bottom bg-cover opacity-15 dark:opacity-10" 
                 style="background-image: url('/images/fuji_bg.png'); mask-image: linear-gradient(to top, rgba(0,0,0,1) 10%, rgba(0,0,0,0) 100%); -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,1) 10%, rgba(0,0,0,0) 100%);">
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
</style>
