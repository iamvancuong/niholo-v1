<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    course: {
        type: Object,
        required: true,
    },
    category: {
        type: String,
        required: true,
    },
    lessons: {
        type: Array,
        required: true,
    },
});

const categoryNames = {
    vocabulary: 'Từ vựng',
    grammar: 'Ngữ pháp',
    kanji: 'Chữ Hán'
};
</script>

<template>
    <Head :title="$t(course.name)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('courses.show', course.id)" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ $t(course.name) }} <span class="text-gray-400 mx-2">/</span> {{ categoryNames[category] }}
                </h2>
            </div>
        </template>

        <div class="py-12 relative overflow-hidden min-h-screen">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <!-- Pathway Layout -->
                <div class="relative py-10">
                    <!-- The vertical line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-4 bg-gray-200 dark:bg-gray-700 rounded-full z-0"></div>
                    
                    <div class="space-y-16">
                        <div 
                            v-for="(lesson, index) in lessons" 
                            :key="lesson.id"
                            class="relative z-10 flex flex-col items-center"
                            :class="[index % 2 === 0 ? 'ml-0 md:ml-32' : 'mr-0 md:mr-32']"
                        >
                            <div class="glass-panel p-6 rounded-2xl shadow-xl w-72 text-center transform transition duration-300 hover:scale-105 hover:-translate-y-2 group">
                                <div class="relative w-16 h-16 mx-auto mb-4">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-inner"
                                         :class="[lesson.cards_count > 0 ? 'bg-gradient-to-r from-niholo-indigo to-niholo-pink' : 'bg-gray-400 dark:bg-gray-600']">
                                        {{ index + 1 }}
                                    </div>
                                    <!-- Badge số thẻ cần ôn -->
                                    <span 
                                        v-if="lesson.due_cards_count > 0"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-gray-800 animate-pulse"
                                    >
                                        {{ lesson.due_cards_count > 99 ? '99+' : lesson.due_cards_count }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $t(lesson.title) }}</h3>
                                
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex justify-center space-x-2">
                                    <span class="bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded text-niholo-indigo">{{ lesson.cards_count }} Thẻ</span>
                                    <span v-if="lesson.due_cards_count > 0" class="bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded text-red-500 font-semibold">
                                        {{ lesson.due_cards_count }} cần ôn
                                    </span>
                                    <span v-else-if="lesson.cards_count > 0" class="bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded text-green-500">
                                        ✓ Đã ôn xong
                                    </span>
                                </div>

                                <div class="flex flex-col space-y-3 w-full">
                                    <!-- Nút Lý thuyết Ngữ pháp -->
                                    <Link 
                                        v-if="category === 'grammar'"
                                        :href="route('grammar.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-niholo-indigo text-niholo-indigo rounded-xl font-bold transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 active:scale-95"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            Lý thuyết
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Học Kanji -->
                                    <Link 
                                        v-else-if="category === 'kanji'"
                                        :href="route('kanji.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-orange-500 text-orange-500 rounded-xl font-bold transition-all hover:bg-orange-50 dark:hover:bg-orange-900/20 active:scale-95"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                                            Học Kanji
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Từ vựng (Cho Từ vựng) -->
                                    <Link 
                                        v-else-if="category === 'vocabulary'"
                                        :href="route('vocabulary.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-green-500 text-green-500 rounded-xl font-bold transition-all hover:bg-green-50 dark:hover:bg-green-900/20 active:scale-95"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Từ vựng
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Ôn tập thẻ (Flashcard) -->
                                    <Link 
                                        :href="route('study.session', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-bold text-white transition-all transform active:scale-95"
                                        :class="[lesson.cards_count > 0 ? 'bg-gradient-to-r from-niholo-indigo to-niholo-pink shadow-lg hover:opacity-90' : 'bg-gray-400 cursor-not-allowed']"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            Ôn tập Thẻ
                                            <span v-if="lesson.due_cards_count > 0" class="ml-2 bg-white/30 px-2 py-0.5 rounded-full text-xs">
                                                {{ lesson.due_cards_count }}
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Ghép câu -->
                                    <Link 
                                        v-if="lesson.cards && lesson.cards.length > 0"
                                        :href="route('puzzle.show', { lesson: lesson.id, card: lesson.cards[0].id })"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-niholo-pink text-niholo-pink rounded-xl font-bold transition-all hover:bg-pink-50 dark:hover:bg-pink-900/20 active:scale-95"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                                            Ghép câu
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
