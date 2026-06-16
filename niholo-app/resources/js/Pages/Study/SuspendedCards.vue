<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    suspendedReviews: Object,
    currentTab: String,
});

const unsuspend = (reviewId) => {
    router.post(route('vault.unsuspend', reviewId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Success handled by flash message if any, or just disappear from list
        }
    });
};
</script>

<template>
    <Head title="Kho thẻ cách ly" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <span>📦</span> Kho thẻ cách ly (Vault)
                </h2>
                <Link :href="route('dashboard')" class="text-sm text-niholo-indigo hover:underline">
                    &larr; Trở về Dashboard
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100 dark:border-gray-700 p-6">
                    
                    <div class="mb-6">
                        <p class="text-gray-500 dark:text-gray-400">
                            Kho thẻ giúp bạn quản lý những từ vựng không-muốn-học-vào-lúc-này. 
                            Bạn có thể <b>Gỡ cách ly</b> để đưa chúng quay lại hàng đợi ôn tập bất kỳ lúc nào.
                        </p>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-4 mb-8 border-b border-gray-200 dark:border-gray-700">
                        <Link :href="route('vault.index', { tab: 'leech' })" 
                              class="px-4 py-3 font-bold transition flex-1 sm:flex-none text-center"
                              :class="currentTab === 'leech' ? 'text-niholo-indigo border-b-2 border-niholo-indigo' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'">
                            Thẻ cực khó (Quên nhiều)
                        </Link>
                        <Link :href="route('vault.index', { tab: 'manual' })" 
                              class="px-4 py-3 font-bold transition flex-1 sm:flex-none text-center"
                              :class="currentTab === 'manual' ? 'text-niholo-indigo border-b-2 border-niholo-indigo' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'">
                            Đã thuộc (Tạm ngưng)
                        </Link>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6" v-if="suspendedReviews.data.length > 0">
                        <h3 class="text-xl font-black text-gray-800 dark:text-gray-200">
                            {{ currentTab === 'leech' ? 'Thẻ cực khó cần ôn tập' : 'Thẻ đã thuộc' }}
                        </h3>
                        <Link :href="route('vault.study', { tab: currentTab })" class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transition-transform hover:-translate-y-0.5 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Ôn tập chuyên sâu
                        </Link>
                    </div>

                    <div v-if="suspendedReviews.data.length === 0" class="text-center py-12">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Không có thẻ nào ở đây!</h3>
                        <p class="text-gray-500 mt-2">
                            {{ currentTab === 'leech' ? 'Bạn chưa có thẻ nào bị hệ thống đánh giá là quá khó.' : 'Bạn chưa chủ động tạm ngưng thẻ nào.' }}
                        </p>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="review in suspendedReviews.data" :key="review.id" 
                             class="flex flex-col justify-between p-5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span v-if="review.is_leech" class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-md">
                                        Thẻ khó (Leech)
                                    </span>
                                    <span v-else class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-md">
                                        Đã tạm ngưng
                                    </span>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-1">
                                    {{ review.card.front_text }}
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">
                                    {{ review.card.back_text }} ({{ review.card.reading }})
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-xs text-gray-400">
                                    Khóa học: {{ review.card.lesson?.course?.level || 'N/A' }}
                                </span>
                                <button @click="unsuspend(review.id)" class="px-4 py-2 bg-indigo-50 text-niholo-indigo hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-900/50 rounded-xl text-sm font-bold transition">
                                    Gỡ cách ly
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center" v-if="suspendedReviews.last_page > 1">
                        <div class="flex gap-2">
                            <Link v-for="(link, i) in suspendedReviews.links" :key="i"
                                  :href="link.url || '#'"
                                  class="px-4 py-2 rounded-xl text-sm font-medium transition"
                                  :class="[
                                      link.active ? 'bg-niholo-indigo text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600',
                                      !link.url && 'opacity-50 cursor-not-allowed'
                                  ]"
                                  v-html="link.label">
                            </Link>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
