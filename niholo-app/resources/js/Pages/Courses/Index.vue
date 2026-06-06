<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    courses: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Courses" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h2 class="text-2xl font-black leading-tight text-gray-900 dark:text-white">
                    {{ t('courses') }}
                </h2>
            </div>
        </template>

        <div class="py-12 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-niholo-indigo rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute top-40 -left-40 w-96 h-96 bg-niholo-pink rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            </div>

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="(course, index) in courses" 
                        :key="course.id"
                        class="group relative overflow-hidden rounded-3xl bg-white dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-500/30 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
                    >
                        <!-- Card Header Background (Dynamic color based on index) -->
                        <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-br opacity-20 dark:opacity-40"
                             :class="[
                                index % 3 === 0 ? 'from-emerald-400 to-teal-500' : '',
                                index % 3 === 1 ? 'from-indigo-400 to-violet-500' : '',
                                index % 3 === 2 ? 'from-rose-400 to-pink-500' : ''
                             ]"
                        ></div>
                        <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-t from-white dark:from-gray-800 to-transparent"></div>

                        <div class="relative p-8">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 bg-gradient-to-br"
                                     :class="[
                                        index % 3 === 0 ? 'from-emerald-500 to-teal-600 shadow-emerald-500/30' : '',
                                        index % 3 === 1 ? 'from-indigo-500 to-violet-600 shadow-indigo-500/30' : '',
                                        index % 3 === 2 ? 'from-rose-500 to-pink-600 shadow-pink-500/30' : ''
                                     ]"
                                >
                                    {{ course.name.substring(0, 2) }}
                                </div>
                                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-bold px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600">
                                    {{ course.lessons_count }} bài học
                                </span>
                            </div>
                            
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $t(course.name) }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8 line-clamp-2 text-sm leading-relaxed">
                                {{ $t(course.description) || 'Lộ trình tiêu chuẩn giúp bạn chinh phục JLPT. Từ vựng, ngữ pháp, Hán tự được thiết kế bài bản.' }}
                            </p>
                            
                            <Link 
                                :href="route('courses.show', course.id)"
                                class="flex w-full justify-center items-center px-6 py-4 bg-gray-50 hover:bg-indigo-50 dark:bg-gray-900/50 dark:hover:bg-indigo-900/30 text-gray-900 dark:text-white rounded-xl font-bold transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-500/30 group-hover:text-indigo-600 dark:group-hover:text-indigo-400"
                            >
                                <span class="mr-2">Bắt đầu học</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
</style>
