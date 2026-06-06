<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    exam: {
        type: Object,
        required: true,
    },
    totalDuration: {
        type: Number,
        required: true,
    },
    attempts: {
        type: Array,
        default: () => [],
    }
});

const sectionNames = {
    'moji_goi': 'Từ vựng - Chữ Hán',
    'bunpou_dokkai': 'Ngữ pháp - Đọc hiểu',
    'choukai': 'Nghe hiểu'
};

const bestAttempt = computed(() => {
    if (!props.attempts || props.attempts.length === 0) return null;
    return props.attempts.reduce((best, current) => {
        return (current.score > best.score) ? current : best;
    }, props.attempts[0]);
});

</script>

<template>
    <Head :title="exam.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('exams.index')" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ exam.title }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-8 md:p-12 text-center border-b border-gray-100 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-100 to-pink-100 dark:from-indigo-900/40 dark:to-pink-900/40 mb-6 shadow-inner">
                            <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-niholo-indigo to-niholo-pink">
                                {{ exam.level }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ exam.title }}</h1>
                        <div class="flex flex-wrap justify-center gap-4 text-gray-600 dark:text-gray-400 mb-8">
                            <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 px-4 py-2 rounded-full">
                                <svg class="w-5 h-5 mr-2 text-niholo-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold">{{ totalDuration }} Phút</span>
                            </div>
                            <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 px-4 py-2 rounded-full">
                                <svg class="w-5 h-5 mr-2 text-niholo-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span class="font-semibold">{{ exam.sections.length }} Phần thi</span>
                            </div>
                        </div>

                        <Link
                            :href="route('exams.take', exam.id)"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-xl text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all active:scale-95"
                        >
                            Bắt đầu làm bài
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </Link>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Lưu ý: Thời gian sẽ bắt đầu đếm ngược ngay khi bạn bấm nút.</p>
                    </div>

                    <div class="p-8 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <!-- Cấu trúc đề thi -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-niholo-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Cấu trúc bài thi
                                </h3>
                                <ul class="space-y-4">
                                    <li v-for="(section, index) in exam.sections" :key="section.id" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-niholo-indigo flex items-center justify-center font-bold mr-4 shrink-0">
                                            {{ index + 1 }}
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ sectionNames[section.type] || section.type }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Thời gian: {{ section.duration_minutes }} phút</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Lịch sử làm bài -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-niholo-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Lịch sử làm bài
                                </h3>
                                
                                <div v-if="attempts.length > 0">
                                    <div class="mb-6 p-6 bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-indigo-900/20 dark:to-pink-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800/30">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1">Thành tích tốt nhất</p>
                                        <div class="flex items-end">
                                            <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-niholo-indigo to-niholo-pink">{{ bestAttempt.score }}</span>
                                            <span class="text-xl text-gray-500 dark:text-gray-400 mb-1 ml-1">/ {{ bestAttempt.total_score }}</span>
                                        </div>
                                    </div>

                                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                        <Link 
                                            v-for="attempt in attempts" 
                                            :key="attempt.id"
                                            :href="route('exams.result', attempt.id)"
                                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                                        >
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-gray-200">{{ attempt.score }} / {{ attempt.total_score }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ new Date(attempt.completed_at).toLocaleString('vi-VN') }}</p>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </Link>
                                    </div>
                                </div>
                                <div v-else class="text-center py-8 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                                    <p class="text-gray-500 dark:text-gray-400">Bạn chưa làm đề này lần nào.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 20px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #475569;
}
</style>
