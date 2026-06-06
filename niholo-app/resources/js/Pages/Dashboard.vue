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
    <Head title="Bảng Điều Khiển" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-white flex items-center gap-2">
                <span>👋</span> Xin chào, {{ $page.props.auth.user.name }}!
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <!-- Gamification Top Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    <!-- Streak & XP Widget -->
                    <div class="glass-panel overflow-hidden bg-gradient-to-br from-orange-400 to-red-500 rounded-3xl shadow-lg relative p-6 text-white transform transition hover:scale-[1.02] flex flex-col justify-between">
                        <div class="absolute -right-6 -top-6 text-9xl opacity-20">🔥</div>
                        
                        <div>
                            <h3 class="text-lg font-medium opacity-90">Chuỗi học tập</h3>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-6xl font-black">{{ streakDays }}</span>
                                <span class="text-xl font-semibold opacity-90">ngày</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-white/20">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold">Cấp độ {{ currentLevel }}</span>
                                <span class="text-sm opacity-90 font-medium">{{ currentLevelXp }} / {{ xpToNextLevel }} XP</span>
                            </div>
                            <div class="w-full bg-black/20 rounded-full h-3 overflow-hidden shadow-inner relative" :class="{'ring-2 ring-white/50 ring-offset-2 ring-offset-orange-500 shadow-[0_0_15px_rgba(255,255,255,0.5)] animate-pulse': isCloseToLevelUp}">
                                <div class="bg-white h-3 rounded-full transition-all duration-1000 relative" :style="`width: ${levelProgress}%`">
                                    <div v-if="isCloseToLevelUp" class="absolute inset-0 bg-white opacity-50 animate-ping rounded-full"></div>
                                </div>
                            </div>
                            <p v-if="isCloseToLevelUp" class="text-xs text-white mt-2 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path></svg>
                                Sắp lên cấp, cố lên!
                            </p>
                            <p v-else class="text-xs text-white/80 mt-2 flex justify-between">
                                <span>Tổng: {{ totalXp }} XP</span>
                            </p>
                        </div>
                    </div>

                    <!-- Progress Widget -->
                    <div class="glass-panel bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:col-span-2 relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500 rounded-full blur-3xl opacity-10 dark:opacity-20"></div>
                        
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Tiến độ khóa N5</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Chinh phục 600 từ vựng và Kanji</p>
                            </div>
                            <div class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/40 text-niholo-indigo dark:text-indigo-400 rounded-full text-sm font-bold">
                                {{ progressN5 }}%
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-4 mb-6 overflow-hidden">
                            <div class="bg-gradient-to-r from-niholo-indigo to-niholo-pink h-4 rounded-full transition-all duration-1000" :style="`width: ${progressN5}%`"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Thẻ đã học</span>
                                <span class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ learnedCards }} / {{ totalCardsN5 }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Ngữ pháp</span>
                                <span class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ learnedGrammar }} / {{ totalGrammarN5 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main CTA -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 flex flex-col items-center justify-center text-center min-h-[300px] relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-gray-800 dark:to-gray-800 opacity-50 group-hover:opacity-100 transition duration-500"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-10 h-10 text-niholo-indigo dark:text-indigo-400 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Đến lúc học tiếp rồi!</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md">Bạn đang có 24 thẻ cần ôn tập hôm nay. Ôn tập đúng hạn sẽ giúp bạn ghi nhớ sâu hơn.</p>
                                
                                <Link :href="route('courses.index')" class="px-8 py-3 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white rounded-full font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition text-lg">
                                    Bắt đầu học ngay
                                </Link>
                                
                                <Link :href="route('vault.index')" class="mt-4 text-sm text-gray-500 hover:text-niholo-indigo hover:underline transition flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Quản lý thẻ đã cách ly
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Leaderboard -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Bảng xếp hạng tuần
                        </h3>
                        
                        <div class="space-y-4">
                            <div v-for="(user, index) in leaderboard" :key="user.user_id" 
                                 class="flex items-center justify-between p-3 rounded-2xl transition"
                                 :class="user.user_id === $page.props.auth.user.id ? 'bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm"
                                         :class="[
                                             index === 0 ? 'bg-yellow-100 text-yellow-600' : 
                                             index === 1 ? 'bg-gray-200 text-gray-600' : 
                                             index === 2 ? 'bg-orange-100 text-orange-600' : 
                                             'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                         ]">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ user.name }}
                                        <span v-if="user.user_id === $page.props.auth.user.id" class="ml-1 text-xs text-indigo-500">(Bạn)</span>
                                    </div>
                                </div>
                                <div class="font-bold text-niholo-indigo dark:text-indigo-400">
                                    {{ user.score }} XP
                                </div>
                            </div>
                            
                            <div v-if="leaderboard.length === 0" class="text-center text-gray-500 dark:text-gray-400 py-4 text-sm">
                                Chưa có ai ghi điểm tuần này. Hãy là người đầu tiên!
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
