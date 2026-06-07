<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    course: Object
});

const categories = [
    {
        id: 'vocabulary',
        name: 'Học Từ vựng',
        description: 'Tích lũy vốn từ cơ bản với Flashcard & Bài tập ghép câu.',
        icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        color: 'text-niholo-indigo'
    },
    {
        id: 'grammar',
        name: 'Học Ngữ pháp',
        description: 'Nắm vững cấu trúc câu qua các tình huống giao tiếp thực tế.',
        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        color: 'text-niholo-pink'
    },
    {
        id: 'kanji',
        name: 'Học Chữ Hán',
        description: 'Phân tích bộ thủ và cách nhớ Hán tự qua hình ảnh.',
        icon: 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129',
        color: 'text-yellow-500'
    }
];
</script>

<template>
    <Head :title="$t(course.name)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('courses.index')" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Khóa học {{ $t(course.name) }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-8 text-center">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Bạn muốn học gì hôm nay?</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Hãy chọn chuyên mục bạn muốn tập trung. Mỗi phần đều có lộ trình bài học riêng biệt được thiết kế tối ưu.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link 
                        v-for="cat in categories" 
                        :key="cat.id"
                        :href="route('lessons.index', { course: course.id, category: cat.id })"
                        :class="['bg-pastel-' + cat.id, 'border-4', 'border-black', 'rounded-3xl', 'p-8', 'shadow-[8px_8px_0px_rgba(0,0,0,1)]', 'hover:shadow-[4px_4px_0px_rgba(0,0,0,1)]', 'transition-all']"
                    >
                        <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" :class="cat.color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="cat.icon"></path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-niholo-indigo transition-colors">{{ cat.name }}</h4>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ cat.description }}
                        </p>
                    </Link>
                </div>
            </div>
        </div>
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

</AuthenticatedLayout>

</template>
