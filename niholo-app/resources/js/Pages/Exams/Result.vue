<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    attempt: {
        type: Object,
        required: true,
    }
});

const sectionNames = {
    'moji_goi': 'Từ vựng - Chữ Hán',
    'bunpou_dokkai': 'Ngữ pháp - Đọc hiểu',
    'choukai': 'Nghe hiểu'
};

const passThreshold = Math.floor(props.attempt.total_score * 0.5); // 50% to pass for mockup
const isPassed = computed(() => props.attempt.score >= passThreshold);

// Calculate section stats
const sectionsArray = computed(() => {
    if (!props.attempt.section_scores_json) return [];
    
    return Object.keys(props.attempt.section_scores_json).map(key => {
        const data = props.attempt.section_scores_json[key];
        const percent = data.max > 0 ? Math.round((data.score / data.max) * 100) : 0;
        return {
            key: key,
            name: sectionNames[key] || key,
            score: data.score,
            max: data.max,
            percent: percent
        };
    });
});

</script>

<template>
    <Head title="Kết quả Thi JLPT" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('exams.show', attempt.exam_id)" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Kết quả làm bài
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden relative">
                    <!-- Ribbon -->
                    <div class="absolute top-0 right-0 transform translate-x-4 -translate-y-4">
                        <div class="w-32 h-32 bg-gradient-to-br" :class="isPassed ? 'from-green-400 to-green-600' : 'from-red-400 to-red-600'" style="clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                    </div>

                    <div class="p-8 md:p-12 text-center relative z-10">
                        <div class="mb-4">
                            <span class="inline-block px-4 py-1 rounded-full text-sm font-bold bg-indigo-50 text-niholo-indigo dark:bg-indigo-900/30">
                                {{ attempt.exam.title }}
                            </span>
                        </div>

                        <!-- Result Title -->
                        <h1 class="text-3xl md:text-5xl font-black mb-6 flex flex-col items-center justify-center">
                            <span v-if="isPassed" class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-emerald-600 mb-2">ĐẠT YÊU CẦU</span>
                            <span v-else class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-600 mb-2">CHƯA ĐẠT</span>
                        </h1>

                        <!-- Main Score -->
                        <div class="flex justify-center items-end mb-8">
                            <span class="text-7xl font-black text-gray-900 dark:text-white leading-none">{{ attempt.score }}</span>
                            <span class="text-3xl text-gray-400 dark:text-gray-500 font-bold mb-1 ml-2">/ {{ attempt.total_score }}</span>
                        </div>

                        <!-- Section breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 text-left">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Chi tiết từng phần</h3>
                            
                            <div class="space-y-4">
                                <div v-for="section in sectionsArray" :key="section.key">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ section.name }}</span>
                                        <span class="text-sm font-bold" :class="section.percent >= 50 ? 'text-green-600 dark:text-green-400' : 'text-red-500'">
                                            {{ section.score }} / {{ section.max }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="h-2.5 rounded-full transition-all duration-1000" 
                                             :class="section.percent >= 50 ? 'bg-gradient-to-r from-green-400 to-green-500' : 'bg-gradient-to-r from-red-400 to-red-500'"
                                             :style="`width: ${section.percent}%`"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4">
                            <Link :href="route('exams.index')" class="px-6 py-3 w-full sm:w-auto bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold rounded-xl transition-colors">
                                Về danh sách đề
                            </Link>
                            <Link :href="route('exams.show', attempt.exam_id)" class="px-6 py-3 w-full sm:w-auto bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all">
                                Xem lại / Làm lại
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
