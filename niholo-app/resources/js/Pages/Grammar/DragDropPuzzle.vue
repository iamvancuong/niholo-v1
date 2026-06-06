<script setup>
import { ref, computed, watch, nextTick } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { VueDraggable } from 'vue-draggable-plus';
import confetti from 'canvas-confetti';
import axios from 'axios';

const props = defineProps({
    lesson: Object,
    card: Object,
    next_card_id: Number,
    puzzle: Object,
});

// --- Audio ---
const audioRef = ref(null);
const playSpeech = (text) => {
    if (!text || !window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = 'ja-JP';
    u.rate = 0.85;
    window.speechSynthesis.speak(u);
};
const playAudio = () => {
    if (props.card.example_audio_url && audioRef.value) {
        audioRef.value.play();
    } else if (props.card.example_japanese) {
        playSpeech(props.card.example_japanese);
    }
};

// --- Tabs ---
const activeTab = ref('arrange'); // 'arrange' | 'write' | 'listen'
const tabs = [
    { id: 'arrange', label: 'Ghép câu', icon: 'M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5' },
    { id: 'write', label: 'Điền chữ', icon: 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z' },
    { id: 'listen', label: 'Nghe & Ghép', icon: 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z' },
];

// --- Shared state ---
const isCorrect = ref(null);
const correctSentence = ref('');
const isSubmitting = ref(false);

// --- Tab 1 & 3: Arrange ---
const sourceBlocks = ref([...props.puzzle.blocks]);
const targetBlocks = ref([]);
const canSubmitArrange = computed(() => sourceBlocks.value.length === 0 && targetBlocks.value.length > 0);

const moveToTarget = (el, index) => {
    sourceBlocks.value.splice(index, 1);
    targetBlocks.value.push(el);
};

const moveToSource = (el, index) => {
    targetBlocks.value.splice(index, 1);
    sourceBlocks.value.push(el);
};

// Auto check when all blocks are placed
watch(canSubmitArrange, (canSubmit) => {
    if (canSubmit && isCorrect.value === null && !isSubmitting.value) {
        submitArrange();
    }
});

const resetArrange = () => {
    sourceBlocks.value = [...props.puzzle.blocks].sort(() => Math.random() - 0.5);
    targetBlocks.value = [];
    isCorrect.value = null;
    correctSentence.value = '';
};

const submitArrange = async () => {
    if (!canSubmitArrange.value) return;
    isSubmitting.value = true;
    try {
        const res = await axios.post(route('puzzle.submit', { lesson: props.lesson.id, card: props.card.id }), {
            answer_order: targetBlocks.value.map(b => b.id)
        });
        isCorrect.value = res.data.correct;
        correctSentence.value = res.data.correct_sentence;
        if (isCorrect.value) {
            fireConfetti();
            setTimeout(() => playAudio(), 500);
        }
    } catch (e) {
        console.error(e);
    } finally {
        isSubmitting.value = false;
    }
};

// --- Tab 2: Write ---
const writeAnswer = ref('');
const normalize = (str) => str.replace(/[。、？！?!.,\s]/g, '');
const canSubmitWrite = computed(() => writeAnswer.value.trim().length > 0);

const submitWrite = () => {
    const userNorm = normalize(writeAnswer.value);
    const correctNorm = normalize(props.card.example_japanese || '');
    isCorrect.value = userNorm === correctNorm;
    correctSentence.value = props.card.example_japanese || '';
    if (isCorrect.value) {
        fireConfetti();
        setTimeout(() => playAudio(), 500);
    }
};
const resetWrite = () => {
    writeAnswer.value = '';
    isCorrect.value = null;
    correctSentence.value = '';
};

// --- Tab 3: Listen - auto play on switch ---
let audioTimeout = null;

watch(activeTab, (val) => {
    isCorrect.value = null;
    correctSentence.value = '';
    clearTimeout(audioTimeout);
    
    if (val === 'listen') {
        resetArrange();
        audioTimeout = setTimeout(() => {
            if (activeTab.value === 'listen') {
                playAudio();
            }
        }, 1000);
    } else if (val === 'arrange') {
        resetArrange();
    } else {
        resetWrite();
    }
});

// --- Confetti ---
const fireConfetti = () => {
    const end = Date.now() + 2000;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };
    const rng = (a, b) => Math.random() * (b - a) + a;
    const iv = setInterval(() => {
        if (Date.now() > end) return clearInterval(iv);
        const p = 50 * ((end - Date.now()) / 2000);
        confetti({ ...defaults, particleCount: p, origin: { x: rng(0.1, 0.3), y: Math.random() - 0.2 } });
        confetti({ ...defaults, particleCount: p, origin: { x: rng(0.7, 0.9), y: Math.random() - 0.2 } });
    }, 250);
};
</script>

<template>
    <Head :title="'Bài tập: ' + $t(lesson.title)" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Bài tập</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">

                <!-- Tab Buttons -->
                <div class="flex space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl mb-6">
                    <button
                        v-for="tab in tabs" :key="tab.id"
                        @click="activeTab = tab.id"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all"
                        :class="activeTab === tab.id ? 'bg-white dark:bg-gray-700 text-niholo-indigo shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="tab.icon"></path></svg>
                        {{ tab.label }}
                    </button>
                </div>

                <!-- Card -->
                <div class="bg-white shadow-xl sm:rounded-2xl dark:bg-gray-800 p-8 border border-gray-100 dark:border-gray-700">

                    <div class="mb-8" v-if="activeTab !== 'listen'">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="bg-niholo-indigo text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">
                                    {{ activeTab === 'arrange' ? '1' : '2' }}
                                </span>
                                <span v-if="activeTab === 'write'">Nghe và điền câu tiếng Nhật:</span>
                                <span v-else>Dịch câu sau sang tiếng Nhật:</span>
                            </div>
                            <audio v-if="card.example_audio_url" ref="audioRef" :src="card.example_audio_url"></audio>
                        </h3>
                        <p class="text-2xl font-semibold text-niholo-indigo dark:text-niholo-pink pl-11">
                            "{{ $t(puzzle.translation) }}"
                        </p>
                    </div>

                    <!-- TAB 3 NEW UI (Listen) -->
                    <div v-if="activeTab === 'listen'" class="mb-10 bg-indigo-50 dark:bg-gray-800/80 rounded-3xl p-6 sm:p-8 shadow-inner border border-indigo-100 dark:border-gray-700">
                        <h3 class="text-niholo-indigo dark:text-indigo-400 font-bold flex items-center mb-6">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"></path></svg>
                            Nghe và sắp xếp lại các mảnh để ghép thành câu tiếng Nhật
                        </h3>

                        <div class="flex items-center space-x-4 mb-8">
                            <button @click="playAudio" class="w-16 h-16 bg-gradient-to-r from-niholo-indigo to-niholo-pink rounded-2xl flex items-center justify-center shrink-0 hover:opacity-90 transition shadow-md">
                                <svg class="w-8 h-8 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"></path></svg>
                            </button>
                            
                            <div class="flex-1 bg-white dark:bg-gray-900 rounded-2xl h-16 flex items-center px-6 justify-between border border-indigo-100 dark:border-gray-700 shadow-sm cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition" @click="playAudio">
                                <button @click.stop="playAudio" class="text-niholo-indigo dark:text-indigo-400 hover:text-niholo-pink transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                </button>
                                
                                <div class="flex-1 flex items-center justify-center space-x-1 h-6 mx-6 opacity-70">
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-1/3 rounded-full animate-pulse"></div>
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-2/3 rounded-full animate-pulse" style="animation-delay: 0.1s"></div>
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-full rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-1/2 rounded-full animate-pulse" style="animation-delay: 0.3s"></div>
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-3/4 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                                    <div class="w-1 bg-niholo-indigo dark:bg-indigo-400 h-1/4 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                                    <div class="w-1 bg-niholo-pink dark:bg-pink-400 h-2/3 rounded-full animate-pulse" style="animation-delay: 0.6s"></div>
                                    <div class="w-1 bg-niholo-pink dark:bg-pink-400 h-1/3 rounded-full animate-pulse" style="animation-delay: 0.7s"></div>
                                </div>
                                
                                <button @click.stop="playAudio" class="text-niholo-indigo dark:text-indigo-400 hover:text-niholo-pink transition" title="Nghe lại">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Target Blocks (Listen) -->
                        <VueDraggable v-model="targetBlocks" group="listen_blocks"
                            class="min-h-[70px] p-4 bg-white/50 dark:bg-gray-900/50 rounded-xl border-2 border-dashed border-indigo-200 dark:border-gray-600 flex flex-wrap gap-3 items-center mb-8 transition-colors"
                            :class="{'border-solid border-niholo-indigo bg-indigo-100/50 dark:border-niholo-indigo dark:bg-indigo-900/20': targetBlocks.length > 0}">
                            <div v-for="(el, index) in targetBlocks" :key="el.id" @click="moveToSource(el, index)" class="px-5 py-3 bg-white dark:bg-gray-800 border-2 border-niholo-indigo rounded-lg shadow-sm font-bold text-lg cursor-pointer text-gray-800 dark:text-white hover:-translate-y-1 transition">
                                {{ el.text }}
                            </div>
                        </VueDraggable>

                        <!-- Source Blocks (Listen) -->
                        <VueDraggable v-if="!isCorrect" v-model="sourceBlocks" group="listen_blocks" class="min-h-[70px] flex flex-wrap gap-3 items-center justify-center">
                            <div v-for="(el, index) in sourceBlocks" :key="el.id" @click="moveToTarget(el, index)" class="px-5 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm font-bold text-lg cursor-pointer text-gray-800 dark:text-white hover:-translate-y-1 transition hover:border-niholo-pink">
                                {{ el.text }}
                            </div>
                        </VueDraggable>
                        <audio v-if="card.example_audio_url" ref="audioRef" :src="card.example_audio_url"></audio>
                    </div>

                    <!-- ==================== TAB 1: ARRANGE ==================== -->
                    <template v-if="activeTab === 'arrange'">
                        <div class="mb-6">
                            <p class="text-sm text-gray-500 mb-3 font-medium uppercase tracking-wider">Kéo hoặc Click từ vào đây</p>
                            <VueDraggable v-model="targetBlocks" group="blocks"
                                class="min-h-[80px] p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-wrap gap-3 items-center transition-colors"
                                :class="{'border-niholo-indigo bg-indigo-50 dark:border-niholo-indigo dark:bg-indigo-900/20': targetBlocks.length > 0}">
                                <div v-for="(el, index) in targetBlocks" :key="el.id" @click="moveToSource(el, index)" class="px-5 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm font-bold text-lg cursor-pointer text-gray-800 dark:text-white hover:-translate-y-1 transition">
                                    {{ el.text }}
                                </div>
                            </VueDraggable>
                        </div>
                        <div class="mb-6" v-if="!isCorrect">
                            <VueDraggable v-model="sourceBlocks" group="blocks" class="min-h-[80px] flex flex-wrap gap-3 items-center justify-center">
                                <div v-for="(el, index) in sourceBlocks" :key="el.id" @click="moveToTarget(el, index)" class="px-5 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-sm font-bold text-lg cursor-pointer text-gray-800 dark:text-white hover:-translate-y-1 transition hover:border-niholo-pink">
                                    {{ el.text }}
                                </div>
                            </VueDraggable>
                        </div>
                    </template>

                    <!-- ==================== TAB 2: WRITE ==================== -->
                    <template v-if="activeTab === 'write'">
                        <div class="mb-10">
                            <label class="text-sm text-gray-500 mb-3 font-medium uppercase tracking-wider block">Nhập câu tiếng Nhật</label>
                            <input
                                v-model="writeAnswer"
                                type="text"
                                class="w-full px-6 py-4 text-xl font-bold border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-white focus:border-niholo-indigo focus:ring-2 focus:ring-niholo-indigo/20 outline-none transition"
                                :class="{ 'border-green-400': isCorrect === true, 'border-red-400': isCorrect === false }"
                                placeholder="Ví dụ: わたしは学生です"
                                :disabled="isCorrect === true"
                                @keyup.enter="submitWrite"
                            />
                            <p class="text-xs text-gray-400 mt-2">* Không cần nhập dấu chấm, dấu hỏi</p>
                        </div>
                    </template>

                    <!-- ==================== FEEDBACK ==================== -->
                    <div v-if="isCorrect !== null" class="mb-8 p-6 rounded-xl animate-fade-in-up" :class="isCorrect ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'">
                        <div v-if="isCorrect">
                            <h4 class="text-xl font-bold text-green-700 flex items-center mb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Chính xác tuyệt đối!
                            </h4>
                            <p class="text-green-600 text-lg">{{ correctSentence }}</p>
                        </div>
                        <div v-else>
                            <h4 class="text-xl font-bold text-red-700 flex items-center mb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Chưa đúng rồi
                            </h4>
                            <p class="text-red-600 mb-2">Đáp án: <strong>{{ correctSentence }}</strong></p>
                            <button @click="activeTab === 'write' ? resetWrite() : resetArrange()" class="px-4 py-2 bg-white text-red-600 border border-red-200 font-bold rounded-lg hover:bg-red-50 transition">Thử lại</button>
                        </div>
                    </div>

                    <!-- ==================== ACTION BUTTONS ==================== -->
                    <div class="flex justify-end space-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <!-- Submit for write tab -->
                        <button
                            v-if="activeTab === 'write' && !isCorrect"
                            @click="submitWrite" :disabled="!canSubmitWrite"
                            class="px-8 py-3 font-bold rounded-xl shadow-lg transition-all"
                            :class="canSubmitWrite ? 'bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white hover:opacity-90 hover:-translate-y-0.5' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                            Kiểm tra
                        </button>
                        <!-- Next -->
                        <Link v-if="isCorrect && next_card_id"
                            :href="route('puzzle.show', { lesson: lesson.id, card: next_card_id })"
                            class="px-8 py-3 font-bold rounded-xl shadow-lg bg-green-500 text-white hover:bg-green-600 transition-all hover:-translate-y-0.5 flex items-center">
                            Câu tiếp theo
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </Link>
                        <Link v-if="isCorrect && !next_card_id"
                            :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                            class="px-8 py-3 font-bold rounded-xl shadow-lg bg-niholo-indigo text-white hover:opacity-90 transition-all hover:-translate-y-0.5 flex items-center">
                            Hoàn thành
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.4s ease-out forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
