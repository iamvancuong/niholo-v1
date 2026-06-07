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
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pastel-pink border-4 border-black flex items-center justify-center text-black shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h2 class="text-3xl font-black leading-tight text-black uppercase tracking-tight">
                    {{ t('courses') }}
                </h2>
            </div>
        </template>

        <div class="py-12 relative overflow-hidden min-h-screen z-10">
            <!-- Background Decoration (Centered with Kanji) -->
            <div class="fixed inset-0 pointer-events-none select-none overflow-hidden z-0 opacity-10">
                <span class="absolute font-black text-black text-8xl rotate-12" style="top: 10%; left: 5%;">日</span>
                <span class="absolute font-black text-black text-9xl -rotate-6" style="top: 25%; left: 85%;">本</span>
                <span class="absolute font-black text-black text-7xl rotate-45" style="top: 65%; left: 10%;">語</span>
                <span class="absolute font-black text-black text-8xl -rotate-12" style="top: 80%; left: 80%;">夢</span>
                <span class="absolute font-black text-black text-9xl rotate-6" style="top: 45%; left: 50%;">愛</span>
                <span class="absolute font-black text-black text-7xl -rotate-12" style="top: 15%; left: 40%;">学</span>
                <span class="absolute font-black text-black text-8xl rotate-12" style="top: 55%; left: 75%;">習</span>
                <span class="absolute font-black text-black text-9xl -rotate-12" style="top: 90%; left: 30%;">笑</span>
            </div>

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(course, index) in courses" 
                        :key="course.id"
                        class="group relative overflow-hidden rounded-3xl bg-white border-4 border-black shadow-[8px_8px_0px_rgba(0,0,0,1)] transition-all duration-300 hover:-translate-y-2 hover:translate-x-1 hover:shadow-[4px_4px_0px_rgba(0,0,0,1)]"
                    >
                        <!-- Card Header Background (Solid Pastel) -->
                        <div class="absolute top-0 inset-x-0 h-32 border-b-4 border-black"
                             :class="[
                                index % 3 === 0 ? 'bg-pastel-pink' : '',
                                index % 3 === 1 ? 'bg-pastel-blue' : '',
                                index % 3 === 2 ? 'bg-pastel-green' : ''
                             ]"
                        ></div>

                        <div class="relative p-8">
                            <div class="flex items-start justify-between mb-8">
                                <div class="w-20 h-20 shrink-0 rounded-2xl flex items-center justify-center text-black font-black text-3xl border-4 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 bg-white z-10"
                                >
                                    {{ course.name.substring(0, 2) }}
                                </div>
                                <span class="bg-white text-black text-base font-black px-4 py-2 rounded-xl border-4 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] z-10">
                                    {{ course.lessons_count }} bài học
                                </span>
                            </div>
                            
                            <h3 class="text-3xl font-black text-black mb-4 uppercase tracking-tight group-hover:text-pastel-blue transition-colors">
                                {{ $t(course.name) }}
                            </h3>
                            <p class="text-gray-800 font-bold mb-8 line-clamp-3 text-lg leading-relaxed">
                                {{ $t(course.description) || 'Lộ trình tiêu chuẩn giúp bạn chinh phục JLPT. Từ vựng, ngữ pháp, Hán tự được thiết kế bài bản.' }}
                            </p>
                            
                            <Link 
                                :href="route('courses.show', course.id)"
                                class="flex w-full justify-center items-center px-6 py-4 bg-pastel-yellow text-black border-4 border-black rounded-xl font-black text-lg transition-all duration-300 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-y-1 hover:translate-x-1 hover:bg-pastel-orange"
                            >
                                <span class="mr-2">Bắt đầu học</span>
                                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

