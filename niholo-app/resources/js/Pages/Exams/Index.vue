<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    exams: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Đề Thi JLPT" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Luyện Thi JLPT
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6 md:p-8">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Danh sách Đề Thi</h3>
                            <p class="text-gray-500 dark:text-gray-400">Chọn đề thi để kiểm tra năng lực của bạn.</p>
                        </div>

                        <div v-if="exams.length === 0" class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400">Hiện tại chưa có đề thi nào.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div 
                                v-for="exam in exams" 
                                :key="exam.id"
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow relative overflow-hidden group"
                            >
                                <!-- Tag trình độ -->
                                <div class="absolute top-0 right-0 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold px-4 py-1 rounded-bl-xl text-sm shadow-md">
                                    {{ exam.level }}
                                </div>

                                <div class="mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-niholo-indigo flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ exam.title }}</h4>
                                </div>

                                <Link 
                                    :href="route('exams.show', exam.id)"
                                    class="mt-4 block w-full text-center px-4 py-2 bg-white dark:bg-gray-800 border-2 border-niholo-indigo text-niholo-indigo font-semibold rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors"
                                >
                                    Xem chi tiết
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
