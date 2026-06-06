<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    lesson: {
        type: Object,
        required: true,
    }
});

const audioRef = ref(null);
const playingId = ref(null);

const playAudio = (text, id) => {
    if (!text || !window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = 'ja-JP';
    u.rate = 0.85;
    
    playingId.value = id;
    u.onend = () => { playingId.value = null; };
    
    window.speechSynthesis.speak(u);
};
</script>

<template>
    <Head :title="'Từ vựng: ' + $t(lesson.title)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        {{ $t(lesson.title) }} <span class="text-gray-400 mx-2">/</span> Từ vựng
                    </h2>
                </div>
                
                <div class="flex gap-2">
                    <Link :href="route('study.session', lesson.id)" class="px-4 py-2 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white rounded-lg font-bold shadow-md hover:shadow-lg transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Ôn tập thẻ
                    </Link>
                    <Link v-if="lesson.cards.length > 0" :href="route('puzzle.show', { lesson: lesson.id, card: lesson.cards[0].id })" class="px-4 py-2 bg-white dark:bg-gray-800 text-niholo-pink border border-niholo-pink rounded-lg font-bold hover:bg-pink-50 dark:hover:bg-pink-900/20 transition flex items-center">
                        Ghép câu
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Danh sách từ vựng ({{ lesson.cards.length }})</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div v-for="(card, index) in lesson.cards" :key="card.id" class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex flex-col md:flex-row gap-6">
                            
                            <!-- Word & Reading -->
                            <div class="md:w-1/3 flex items-start">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-niholo-indigo flex items-center justify-center font-bold mr-4 shrink-0">
                                    {{ index + 1 }}
                                </div>
                                <div>
                                    <h4 class="text-3xl font-black text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                                        {{ card.front_text }}
                                        <button @click="playAudio(card.front_text, card.id)" class="text-gray-400 hover:text-niholo-pink transition p-1 rounded-full hover:bg-pink-50 dark:hover:bg-pink-900/30" :class="{'text-niholo-pink animate-pulse': playingId === card.id}">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </h4>
                                    <p class="text-lg text-niholo-indigo dark:text-indigo-400 font-medium">{{ card.reading }}</p>
                                </div>
                            </div>

                            <!-- Meaning & Example -->
                            <div class="md:w-2/3">
                                <p class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                    {{ $t(card.back_text) }}
                                </p>
                                
                                <div v-if="card.example_japanese" class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl group">
                                    <p class="text-gray-900 dark:text-white font-medium mb-1 flex items-start gap-2">
                                        <span>{{ card.example_japanese }}</span>
                                        <button @click="playAudio(card.example_japanese, 'ex_'+card.id)" class="text-gray-400 hover:text-niholo-pink transition shrink-0 mt-0.5 opacity-0 group-hover:opacity-100" :class="{'opacity-100 text-niholo-pink animate-pulse': playingId === 'ex_'+card.id}">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t(card.example_vietnamese) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
