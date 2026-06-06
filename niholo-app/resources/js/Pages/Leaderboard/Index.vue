<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    leaderboard: {
        type: Array,
        default: () => []
    }
});

// Top 3 for Podium
const top3 = computed(() => {
    const sorted = [...props.leaderboard].sort((a, b) => a.rank - b.rank);
    return {
        first: sorted.find(u => u.rank === 1) || null,
        second: sorted.find(u => u.rank === 2) || null,
        third: sorted.find(u => u.rank === 3) || null,
    };
});

// The rest of the list
const others = computed(() => {
    return props.leaderboard.filter(u => u.rank > 3).sort((a, b) => a.rank - b.rank);
});
</script>

<template>
    <Head title="Bảng xếp hạng" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 pt-8 relative z-10">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Bảng xếp hạng</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium text-lg">Top 50 ong chăm chỉ nhất tuần này</p>
                <div class="flex items-center justify-center gap-6 mt-5 text-sm font-bold text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1.5 bg-yellow-50 dark:bg-yellow-900/10 px-3 py-1 rounded-full"><span class="text-yellow-500 text-lg">⚡</span> XP</span>
                    <span class="flex items-center gap-1.5 bg-indigo-50 dark:bg-indigo-900/10 px-3 py-1 rounded-full"><span class="text-indigo-400 text-lg">📚</span> Thẻ đã học</span>
                    <span class="flex items-center gap-1.5 bg-orange-50 dark:bg-orange-900/10 px-3 py-1 rounded-full"><span class="text-orange-500 text-lg">🔥</span> Lộ trình (ngày)</span>
                </div>
            </div>

            <!-- Podium -->
            <div class="flex flex-col md:flex-row items-end justify-center gap-4 md:gap-6 mb-16 pt-8 max-w-3xl mx-auto">
                
                <!-- 2nd Place -->
                <div v-if="top3.second" class="w-full md:w-1/3 order-2 md:order-1 relative group">
                    <!-- Podium Badge -->
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-9 h-9 rounded-full bg-slate-300 border-[3px] border-white dark:border-gray-900 flex items-center justify-center font-black text-slate-700 shadow-md z-20 text-lg">2</div>
                    
                    <div class="bg-white dark:bg-gray-800/90 rounded-3xl p-6 pt-10 text-center border-t-4 border-slate-300 shadow-lg transform transition-transform duration-300 group-hover:-translate-y-2 relative overflow-hidden backdrop-blur-sm">
                        <img :src="top3.second.avatar_url" class="w-20 h-20 rounded-full mx-auto border-4 border-white dark:border-gray-700 shadow-md mb-3" />
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">{{ top3.second.name }}</h3>
                        <div v-if="top3.second.is_premium" class="text-[10px] bg-yellow-100 text-yellow-700 px-2.5 py-0.5 rounded-full inline-block font-bold mt-1 mb-3">Premium</div>
                        <div v-else class="h-5 mt-1 mb-3"></div>
                        
                        <div class="flex items-center justify-center gap-3 text-sm font-bold flex-wrap">
                            <span class="text-yellow-500 w-full text-base mb-1">⚡ {{ top3.second.score }} XP</span>
                            <span class="text-indigo-400 flex items-center gap-1"><span class="text-xs">📚</span> {{ top3.second.total_cards }}</span>
                            <span class="text-orange-400 flex items-center gap-1"><span class="text-xs">🔥</span> {{ top3.second.streak }}</span>
                        </div>
                    </div>
                </div>

                <!-- 1st Place -->
                <div v-if="top3.first" class="w-full md:w-1/3 order-1 md:order-2 relative group md:-mt-10 md:mb-6">
                    <!-- Crown & Badge -->
                    <div class="absolute -top-14 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center">
                        <span class="text-4xl filter drop-shadow-md mb-[-8px]">👑</span>
                        <div class="w-12 h-12 rounded-full bg-yellow-400 border-[4px] border-white dark:border-gray-900 flex items-center justify-center font-black text-yellow-900 shadow-xl text-xl">1</div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-3xl p-[3px] shadow-xl shadow-indigo-500/30 transform transition-transform duration-300 group-hover:-translate-y-3 relative z-10">
                        <div class="bg-white dark:bg-gray-900/95 rounded-[21px] p-6 pt-12 text-center h-full relative overflow-hidden backdrop-blur-xl">
                            <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/50 to-transparent dark:from-indigo-900/20 rounded-[21px] pointer-events-none"></div>
                            <img :src="top3.first.avatar_url" class="w-24 h-24 rounded-full mx-auto border-4 border-yellow-400 shadow-lg mb-3 relative z-10" />
                            <h3 class="font-black text-xl text-gray-900 dark:text-white truncate relative z-10">{{ top3.first.name }}</h3>
                            <div v-if="top3.first.is_premium" class="text-xs bg-gradient-to-r from-yellow-400 to-amber-500 text-yellow-950 px-3 py-1 rounded-full inline-block font-black mt-2 mb-4 relative z-10 shadow-sm tracking-wide">PREMIUM</div>
                            <div v-else class="h-6 mt-2 mb-4"></div>
                            
                            <div class="flex items-center justify-center gap-3 text-base font-black relative z-10 flex-wrap">
                                <span class="text-yellow-500 w-full text-lg mb-1">⚡ {{ top3.first.score }} XP</span>
                                <span class="text-indigo-500 dark:text-indigo-400 flex items-center gap-1"><span class="text-sm">📚</span> {{ top3.first.total_cards }}</span>
                                <span class="text-orange-500 flex items-center gap-1"><span class="text-sm">🔥</span> {{ top3.first.streak }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3rd Place -->
                <div v-if="top3.third" class="w-full md:w-1/3 order-3 md:order-3 relative group">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-9 h-9 rounded-full bg-emerald-500 border-[3px] border-white dark:border-gray-900 flex items-center justify-center font-black text-white shadow-md z-20 text-lg">3</div>
                    
                    <div class="bg-white dark:bg-gray-800/90 rounded-3xl p-6 pt-10 text-center border-t-4 border-emerald-500 shadow-lg transform transition-transform duration-300 group-hover:-translate-y-2 relative overflow-hidden backdrop-blur-sm">
                        <img :src="top3.third.avatar_url" class="w-20 h-20 rounded-full mx-auto border-4 border-white dark:border-gray-700 shadow-md mb-3" />
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">{{ top3.third.name }}</h3>
                        <div v-if="top3.third.is_premium" class="text-[10px] bg-yellow-100 text-yellow-700 px-2.5 py-0.5 rounded-full inline-block font-bold mt-1 mb-3">Premium</div>
                        <div v-else class="h-5 mt-1 mb-3"></div>
                        
                        <div class="flex items-center justify-center gap-3 text-sm font-bold flex-wrap">
                            <span class="text-yellow-500 w-full text-base mb-1">⚡ {{ top3.third.score }} XP</span>
                            <span class="text-indigo-400 flex items-center gap-1"><span class="text-xs">📚</span> {{ top3.third.total_cards }}</span>
                            <span class="text-orange-400 flex items-center gap-1"><span class="text-xs">🔥</span> {{ top3.third.streak }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="leaderboard.length === 0" class="text-center py-20 bg-white dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-6xl mb-4">👻</div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Bảng xếp hạng đang trống</h3>
                <p class="text-gray-500">Hãy là người đầu tiên ghi điểm trong tuần này!</p>
            </div>

            <!-- List (Others) -->
            <div v-if="others.length > 0" class="space-y-3">
                <div v-for="user in others" :key="user.user_id" 
                     class="bg-white dark:bg-gray-800/90 backdrop-blur-sm border border-gray-100 dark:border-gray-700/80 rounded-2xl p-4 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow group">
                    
                    <div class="flex items-center gap-4 md:gap-5 w-1/2">
                        <div class="w-8 text-center font-bold text-gray-400 dark:text-gray-500 text-lg">
                            {{ user.rank < 10 ? '0' + user.rank : user.rank }}
                        </div>
                        <img :src="user.avatar_url" class="w-12 h-12 rounded-full border-2 border-gray-100 dark:border-gray-700" />
                        <div class="min-w-0">
                            <div class="font-bold text-gray-900 dark:text-white text-base truncate">{{ user.name }}</div>
                            <div v-if="user.is_premium" class="text-[10px] bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-2 py-0.5 rounded-sm inline-block font-bold mt-0.5 tracking-wide">PREMIUM</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 md:gap-8 font-bold justify-end w-1/2">
                        <div class="text-yellow-500 flex items-center justify-end gap-1.5 w-24 md:w-32">
                            <span class="text-lg hidden md:inline">⚡</span> {{ user.score }} <span class="text-xs text-gray-400 font-medium hidden sm:inline">XP</span>
                        </div>
                        <div class="text-indigo-400 flex items-center justify-end gap-1.5 w-16 hidden sm:flex">
                            <span class="text-lg hidden md:inline">📚</span> {{ user.total_cards }}
                        </div>
                        <div class="text-orange-400 flex items-center justify-end gap-1.5 w-16 hidden sm:flex">
                            <span class="text-lg hidden md:inline">🔥</span> {{ user.streak }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Background Decoration (Centered with Kanji) -->
        <div class="fixed bottom-0 inset-x-0 h-[300px] md:h-[400px] pointer-events-none z-0 overflow-hidden">
            <!-- Fuji Image -->
            <div class="absolute bottom-0 inset-x-0 w-full h-full bg-no-repeat bg-bottom bg-cover opacity-[0.15] dark:opacity-[0.05]" 
                 style="background-image: url('/images/fuji_bg.png'); mask-image: linear-gradient(to top, rgba(0,0,0,1) 10%, rgba(0,0,0,0) 100%); -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,1) 10%, rgba(0,0,0,0) 100%);">
            </div>
        </div>

    </AuthenticatedLayout>
</template>
