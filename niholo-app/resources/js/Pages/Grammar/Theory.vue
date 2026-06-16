<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { marked } from 'marked';

const props = defineProps({
    lesson: Object,
    grammarPoints: Array
});

// Configure marked to open links in new tab, and sanitize if needed
marked.setOptions({
    breaks: true, // Convert \n to <br>
    gfm: true
});

const parseMarkdown = (text) => {
    if (!text) return '';
    return marked.parse(text);
};

const playAudio = (urlOrText) => {
    if (!urlOrText) return;
    if (urlOrText.startsWith('http')) {
        const audio = new Audio(urlOrText);
        audio.play();
    } else {
        // Fallback to TTS if no URL (using Web Speech API)
        const utterance = new SpeechSynthesisUtterance(urlOrText);
        utterance.lang = 'ja-JP';
        window.speechSynthesis.speak(utterance);
    }
};
</script>

<template>
    <Head :title="'Lý thuyết: ' + $t(lesson.title)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link
                    :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                    class="h-10 px-4 flex items-center justify-center gap-2 border border-gray-200 rounded-xl bg-white shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-1 transition-all font-bold text-gray-700 mr-4"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span class="hidden sm:inline">Quay lại</span>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ $t(lesson.title) }} <span class="text-gray-400 mx-2">/</span> Lý thuyết
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-12">

                <!-- Header Intro -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-gray-100 dark:border-gray-700 text-center">
                    <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-niholo-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Lý thuyết Ngữ pháp</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg max-w-2xl mx-auto">
                        Hãy đọc hiểu các cấu trúc dưới đây trước khi vào mục Ôn tập Thẻ để làm bài tập điền khuyết nhé!
                    </p>
                </div>

                <!-- Grammar Points List -->
                <div v-for="(gp, index) in grammarPoints" :key="gp.id" class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <!-- Title Banner -->
                    <div class="bg-gradient-to-r from-niholo-indigo to-niholo-pink p-6 text-white relative overflow-hidden">
                        <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-1/4 -translate-y-1/4">
                            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13.5h-13L12 6.5z"/></svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center relative z-10">
                            <span class="bg-white/20 px-3 py-1 rounded-lg mr-4 text-xl">#{{ index + 1 }}</span>
                            {{ $t(gp.title) }}
                        </h2>
                    </div>

                    <!-- Explanation Body -->
                    <div class="p-6 md:p-10">
                        <h3 class="text-lg font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Giải thích chi tiết</h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none mb-10 text-gray-700 dark:text-gray-300 grammar-explanation" v-html="parseMarkdown($t(gp.cure_dolly_explanation))">
                        </div>

                        <!-- Examples Section -->
                        <div v-if="gp.cards && gp.cards.length > 0">
                            <h3 class="text-lg font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Câu ví dụ</h3>
                            <div class="space-y-4">
                                <div v-for="card in gp.cards" :key="card.id" class="p-5 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-niholo-indigo/30 transition-colors group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <!-- Japanese Sentence -->
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2 font-japanese">
                                                {{ card.example_japanese }}
                                            </p>
                                            <!-- Meaning -->
                                            <p class="text-gray-600 dark:text-gray-400 text-lg">
                                                {{ $t(card.front_text) }}
                                            </p>
                                        </div>
                                        <!-- Play Audio Button -->
                                        <button @click="playAudio(card.example_audio_url || card.example_japanese)" class="ml-4 p-3 bg-white dark:bg-gray-800 rounded-full shadow-sm text-niholo-pink hover:text-white hover:bg-niholo-pink transition-all border border-gray-200 dark:border-gray-700 group-hover:scale-110 active:scale-95 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4 pb-12">
                    <Link
                        :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                        class="px-6 py-4 w-full sm:w-auto text-center bg-white border-2 border-gray-200 rounded-xl font-bold text-gray-700 shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 text-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Quay lại danh sách
                    </Link>
                    <Link 
                        :href="route('study.session', lesson.id)"
                        class="px-8 py-4 w-full sm:w-auto text-center bg-[#aaed5a] text-black text-xl font-black rounded-xl border-4 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none transition-all transform hover:translate-y-1 hover:translate-x-1 flex items-center justify-center"
                    >
                        Vào Ôn tập Thực hành
                        <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Scoped styles for dynamically injected markdown content */
.grammar-explanation strong {
    color: #4f46e5; /* indigo-600 */
    font-weight: 800;
}
.dark .grammar-explanation strong {
    color: #ec4899; /* pink-500 */
}
.grammar-explanation p {
    margin-bottom: 1rem;
}
.font-japanese {
    font-family: 'Noto Sans JP', sans-serif;
}
</style>
