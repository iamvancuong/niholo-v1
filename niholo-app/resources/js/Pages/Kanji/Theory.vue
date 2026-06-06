<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch, nextTick } from 'vue';
import HanziWriter from 'hanzi-writer';
import confetti from 'canvas-confetti';

const props = defineProps({
    lesson: Object,
    kanjis: Array
});

const selectedKanji = ref(null);
const writerContainer = ref(null);
let writer = null;
const isQuizMode = ref(false);

const vocabCards = computed(() => {
    if (!selectedKanji.value || !selectedKanji.value.cards) return [];
    return selectedKanji.value.cards.filter(c => c.type === 'vocabulary');
});

onMounted(() => {
    if (props.kanjis && props.kanjis.length > 0) {
        selectKanji(props.kanjis[0]);
    }
});

const selectKanji = async (kanji) => {
    selectedKanji.value = kanji;
    isQuizMode.value = false;
    await nextTick();
    initWriter(kanji.character);
};

const initWriter = (character) => {
    if (!writerContainer.value) return;
    
    writerContainer.value.innerHTML = ''; // Clear old writer
    
    writer = HanziWriter.create(writerContainer.value, character, {
        width: 150,
        height: 150,
        padding: 5,
        strokeAnimationSpeed: 1,
        delayBetweenStrokes: 50,
        strokeColor: '#4f46e5', // indigo-600
        radicalColor: '#ec4899', // pink-500
        showOutline: true
    });
};

const animateStrokes = () => {
    if (writer) {
        isQuizMode.value = false;
        writer.animateCharacter();
    }
};

const startQuiz = () => {
    if (writer) {
        isQuizMode.value = true;
        writer.quiz({
            onComplete: function() {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
                isQuizMode.value = false;
            }
        });
    }
};

const playAudio = (text) => {
    if (!text) return;
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'ja-JP';
    window.speechSynthesis.speak(utterance);
};
</script>

<template>
    <Head :title="'Học Kanji: ' + $t(lesson.title)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ $t(lesson.title) }} <span class="text-gray-400 mx-2">/</span> Học Kanji
                </h2>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <!-- Left Sidebar: Kanji List -->
                    <div class="w-full lg:w-1/4">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-6">
                            <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                <h3 class="font-bold text-gray-700 dark:text-gray-300">Danh sách chữ Hán ({{ kanjis.length }})</h3>
                            </div>
                            <div class="p-2 max-h-[70vh] overflow-y-auto">
                                <div class="grid grid-cols-3 gap-2">
                                    <button 
                                        v-for="kanji in kanjis" 
                                        :key="kanji.id"
                                        @click="selectKanji(kanji)"
                                        class="aspect-square flex flex-col items-center justify-center rounded-2xl border-2 transition-all hover:scale-105"
                                        :class="selectedKanji?.id === kanji.id ? 'border-niholo-indigo bg-indigo-50 dark:bg-indigo-900/30' : 'border-gray-100 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-500'"
                                    >
                                        <span class="text-3xl font-japanese font-bold" :class="selectedKanji?.id === kanji.id ? 'text-niholo-indigo dark:text-indigo-400' : 'text-gray-800 dark:text-gray-200'">
                                            {{ kanji.character }}
                                        </span>
                                        <span class="text-xs text-gray-500 mt-1 truncate w-full text-center px-1">{{ $t(kanji.sino_vietnamese) }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Column: Kanji Details & Writing -->
                    <div class="w-full lg:w-2/4" v-if="selectedKanji">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                            
                            <div class="flex flex-col md:flex-row gap-8 items-start">
                                
                                <!-- HanziWriter Canvas -->
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-3xl p-4 shadow-inner relative">
                                        <div ref="writerContainer" class="w-[150px] h-[150px]"></div>
                                        <div v-if="isQuizMode" class="absolute top-2 right-2 flex space-x-1">
                                            <span class="flex h-3 w-3 relative">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <button @click="animateStrokes" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-colors flex items-center shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Phát vẽ
                                        </button>
                                        <button @click="startQuiz" class="px-4 py-2 bg-niholo-indigo hover:bg-indigo-600 text-white rounded-xl font-semibold transition-colors flex items-center shadow-md">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            Luyện viết
                                        </button>
                                    </div>
                                </div>

                                <!-- Information -->
                                <div class="flex-1 w-full space-y-6">
                                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                                        <div>
                                            <h2 class="text-4xl font-japanese font-black text-gray-900 dark:text-white">{{ selectedKanji.character }}</h2>
                                            <p class="text-xl font-bold text-niholo-indigo mt-1">{{ $t(selectedKanji.sino_vietnamese) }} <span class="text-gray-400 mx-2">•</span> <span class="text-niholo-pink">{{ $t(selectedKanji.meaning) }}</span></p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 font-bold px-3 py-1 rounded-lg text-sm mb-1">{{ selectedKanji.jlpt_level }}</span>
                                            <p class="text-sm text-gray-500">{{ selectedKanji.stroke_count }} nét</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Âm On</h4>
                                            <div class="flex flex-wrap gap-2">
                                                <span v-for="on in selectedKanji.onyomi" :key="on" class="px-2 py-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded shadow-sm font-japanese text-lg">{{ on }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Âm Kun</h4>
                                            <div class="flex flex-wrap gap-2">
                                                <span v-for="kun in selectedKanji.kunyomi" :key="kun" class="px-2 py-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded shadow-sm font-japanese text-lg">{{ kun }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selectedKanji.mnemonic" class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-2xl border border-yellow-100 dark:border-yellow-800/50">
                                        <h4 class="text-xs font-bold text-yellow-600 dark:text-yellow-500 flex items-center mb-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Gợi ý cách nhớ
                                        </h4>
                                        <p class="text-gray-700 dark:text-gray-300 italic">{{ $t(selectedKanji.mnemonic) }}</p>
                                    </div>
                                </div>

                            </div>

                            <!-- Enter review button -->
                            <div class="mt-10 flex justify-center border-t border-gray-100 dark:border-gray-700 pt-8">
                                <Link 
                                    :href="route('study.session', lesson.id)"
                                    class="px-8 py-3 bg-gradient-to-r from-orange-400 to-orange-500 text-white text-lg font-bold rounded-2xl shadow-lg hover:shadow-xl hover:opacity-90 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center"
                                >
                                    Ôn tập Flashcard
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                </Link>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column: Vocabulary Uses -->
                    <div class="w-full lg:w-1/4" v-if="selectedKanji">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-between">
                                <h3 class="font-bold text-gray-700 dark:text-gray-300">Từ vựng chứa {{ selectedKanji.character }}</h3>
                                <span class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs px-2 py-1 rounded-full font-bold">{{ vocabCards.length }}</span>
                            </div>
                            
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                <div v-if="vocabCards.length === 0" class="p-6 text-center text-gray-500">
                                    Chưa có từ vựng nào dùng chữ này.
                                </div>
                                <div 
                                    v-for="card in vocabCards" 
                                    :key="card.id"
                                    class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group flex items-start justify-between"
                                >
                                    <div>
                                        <div class="flex items-baseline mb-1">
                                            <span class="text-xl font-bold font-japanese text-gray-900 dark:text-white mr-2">
                                                <!-- Attempt to show the Japanese word containing the kanji -->
                                                {{ card.example_japanese || card.front_text }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $t(card.back_text) }}</p>
                                    </div>
                                    <button @click="playAudio(card.example_japanese || card.front_text)" class="p-2 text-gray-400 hover:text-niholo-indigo transition-colors flex-shrink-0 opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                    </button>
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
.font-japanese {
    font-family: 'Noto Sans JP', sans-serif;
}
</style>
