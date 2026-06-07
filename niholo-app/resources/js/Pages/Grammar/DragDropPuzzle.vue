<script setup>
import { ref, computed, watch } from 'vue';
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
const activeTab = ref('arrange');
const tabs = [
    { id: 'arrange', label: 'Ghép câu', emoji: '🧩' },
    { id: 'write',   label: 'Điền chữ', emoji: '✏️' },
    { id: 'listen',  label: 'Nghe & Ghép', emoji: '🎧' },
];

// --- Shared state ---
const isCorrect = ref(null);
const correctSentence = ref('');
const isSubmitting = ref(false);

// --- Arrange ---
const sourceBlocks = ref([...props.puzzle.blocks]);
const targetBlocks = ref([]);

const moveToTarget = (el, index) => {
    sourceBlocks.value.splice(index, 1);
    targetBlocks.value.push(el);
};
const moveToSource = (el, index) => {
    targetBlocks.value.splice(index, 1);
    sourceBlocks.value.push(el);
};

const submitArrange = async (silent = false) => {
    if (targetBlocks.value.length === 0) return;
    if (!silent) isSubmitting.value = true;
    try {
        const res = await axios.post(route('puzzle.submit', { lesson: props.lesson.id, card: props.card.id }), {
            answer_order: targetBlocks.value.map(b => b.id)
        });
        
        if (res.data.correct) {
            isCorrect.value = true;
            correctSentence.value = res.data.correct_sentence;
            fireConfetti(); 
            setTimeout(() => playAudio(), 500);
        } else if (!silent) {
            // Only show wrong answer if user clicked Check button
            isCorrect.value = false;
            correctSentence.value = res.data.correct_sentence;
        }
    } catch (e) { console.error(e); }
    finally { if (!silent) isSubmitting.value = false; }
};

watch(targetBlocks, () => {
    if (isCorrect.value !== true && targetBlocks.value.length > 0) {
        submitArrange(true); // Silent check on every drop
    }
}, { deep: true });

const resetArrange = () => {
    sourceBlocks.value = [...props.puzzle.blocks].sort(() => Math.random() - 0.5);
    targetBlocks.value = [];
    isCorrect.value = null;
    correctSentence.value = '';
};

// --- Write ---
const writeAnswer = ref('');
const normalize = (str) => str.replace(/[。、？！?!.,\s]/g, '');
const canSubmitWrite = computed(() => writeAnswer.value.trim().length > 0);
const submitWrite = () => {
    const userNorm = normalize(writeAnswer.value);
    const correctNorm = normalize(props.card.example_japanese || '');
    isCorrect.value = userNorm === correctNorm;
    correctSentence.value = props.card.example_japanese || '';
    if (isCorrect.value) { fireConfetti(); setTimeout(() => playAudio(), 500); }
};
const resetWrite = () => {
    writeAnswer.value = '';
    isCorrect.value = null;
    correctSentence.value = '';
};

// --- Listen ---
let audioTimeout = null;
watch(activeTab, (val) => {
    isCorrect.value = null;
    correctSentence.value = '';
    clearTimeout(audioTimeout);
    if (val === 'listen') {
        resetArrange();
        audioTimeout = setTimeout(() => { if (activeTab.value === 'listen') playAudio(); }, 1000);
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
            <div class="flex items-center gap-3">
                <Link
                    :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                    class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-xl bg-white shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </Link>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Bài tập ghép câu</p>
                    <h2 class="text-xl font-black text-gray-800">{{ $t(lesson.title) }}</h2>
                </div>
            </div>
        </template>

        <div class="py-10 min-h-screen bg-[#f4f7f4] relative">
            <div class="mx-auto max-w-3xl px-4 lg:px-8">

                <!-- Tab Switcher -->
                <div class="flex gap-3 mb-8">
                    <button
                        v-for="tab in tabs" :key="tab.id"
                        @click="activeTab = tab.id"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 border border-gray-200 rounded-xl font-bold transition-all shadow-sm"
                        :class="activeTab === tab.id
                            ? ['bg-[#eef7e6] text-[#3d7a4a] border-[#c4e8a1]', 'shadow-md', '-translate-y-0.5']
                            : 'bg-white text-gray-600 hover:bg-gray-50 hover:-translate-y-0.5 hover:shadow-md'"
                    >
                        <span class="text-lg">{{ tab.emoji }}</span>
                        {{ tab.label }}
                    </button>
                </div>

                <!-- Main Card -->
                <div class="bg-white border border-gray-100 rounded-3xl shadow-md overflow-hidden">

                    <!-- Question Banner -->
                    <div v-if="activeTab !== 'listen'" class="bg-[#fcfdfa] border-b border-gray-100 p-6">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            {{ activeTab === 'write' ? '✏️ Nghe và điền câu tiếng Nhật:' : '🧩 Dịch câu sau sang tiếng Nhật:' }}
                        </p>
                        <p class="text-2xl font-black text-[#3d7a4a]">
                            "{{ $t(puzzle.translation) }}"
                        </p>
                        <audio v-if="card.example_audio_url" ref="audioRef" :src="card.example_audio_url"></audio>
                    </div>

                    <!-- Listen Banner -->
                    <div v-if="activeTab === 'listen'" class="bg-[#fcfdfa] border-b border-gray-100 p-6">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">🎧 Nghe và sắp xếp lại các mảnh ghép câu</p>
                        <div class="flex items-center gap-4">
                            <button
                                @click="playAudio"
                                class="w-16 h-16 bg-[#eef7e6] text-[#3d7a4a] border border-[#c4e8a1] rounded-2xl flex items-center justify-center shadow-sm hover:shadow-md hover:bg-[#e0f5c4] transition-all shrink-0"
                            >
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"/></svg>
                            </button>
                            <div class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl h-14 flex items-center px-4 gap-1 overflow-hidden">
                                <div v-for="i in 10" :key="i"
                                    class="w-1.5 bg-[#3d7a4a] rounded-full animate-pulse opacity-50"
                                    :style="`height: ${20 + Math.random() * 30}px; animation-delay: ${i * 0.08}s`"
                                ></div>
                            </div>
                            <button @click="playAudio" class="w-10 h-10 border border-gray-200 rounded-xl bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-[#3d7a4a] transition-all shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>
                        <audio v-if="card.example_audio_url" ref="audioRef" :src="card.example_audio_url"></audio>
                    </div>

                    <div class="p-6 space-y-6">

                        <!-- ========== TAB: ARRANGE & LISTEN ========== -->
                        <template v-if="activeTab === 'arrange' || activeTab === 'listen'">
                            <!-- Target Zone -->
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">📥 Kéo hoặc nhấn từ vào đây</p>
                                <VueDraggable
                                    v-model="targetBlocks"
                                    :group="activeTab === 'arrange' ? 'blocks' : 'listen_blocks'"
                                    class="min-h-[70px] p-4 bg-gray-50 border border-gray-200 rounded-2xl flex flex-wrap gap-3 items-center transition-all"
                                    :class="{'border-dashed border-gray-300': targetBlocks.length === 0}"
                                >
                                    <div
                                        v-for="(el, index) in targetBlocks" :key="el.id"
                                        @click="moveToSource(el, index)"
                                        class="px-5 py-2 bg-white border border-gray-200 rounded-xl font-bold text-gray-800 text-lg cursor-pointer shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all"
                                    >
                                        {{ el.text }}
                                    </div>
                                </VueDraggable>
                            </div>

                            <!-- Source Blocks -->
                            <VueDraggable
                                v-if="!isCorrect"
                                v-model="sourceBlocks"
                                :group="activeTab === 'arrange' ? 'blocks' : 'listen_blocks'"
                                class="min-h-[60px] flex flex-wrap gap-3 items-center justify-center"
                            >
                                <div
                                    v-for="(el, index) in sourceBlocks" :key="el.id"
                                    @click="moveToTarget(el, index)"
                                    class="px-5 py-2 bg-white border border-gray-200 rounded-xl font-bold text-gray-800 text-lg cursor-pointer shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all"
                                >
                                    {{ el.text }}
                                </div>
                            </VueDraggable>
                        </template>

                        <!-- ========== TAB: WRITE ========== -->
                        <template v-if="activeTab === 'write'">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-500 block mb-2">✏️ Nhập câu tiếng Nhật</label>
                                <input
                                    v-model="writeAnswer"
                                    type="text"
                                    class="w-full px-6 py-4 text-xl font-bold border border-gray-200 rounded-xl bg-gray-50 text-gray-800 focus:outline-none focus:ring focus:ring-[#c4e8a1] focus:border-[#3d7a4a] transition-all shadow-inner"
                                    :class="{ 'bg-green-50 border-green-200 text-green-800': isCorrect === true, 'bg-red-50 border-red-200 text-red-800': isCorrect === false }"
                                    placeholder="Ví dụ: わたしは学生です"
                                    :disabled="isCorrect === true"
                                    @keyup.enter="submitWrite"
                                />
                                <p class="text-xs text-gray-500 font-medium mt-2">* Không cần nhập dấu chấm, dấu hỏi</p>
                            </div>
                        </template>

                        <!-- ========== FEEDBACK ========== -->
                        <div v-if="isCorrect !== null"
                            class="p-6 border rounded-2xl animate-fade-in-up"
                            :class="isCorrect ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'"
                        >
                            <div v-if="isCorrect">
                                <h4 class="text-xl font-black flex items-center gap-2 mb-2 text-green-700">
                                    ✅ Chính xác tuyệt đối!
                                </h4>
                                <p class="font-bold text-lg text-green-800">{{ correctSentence }}</p>
                            </div>
                            <div v-else>
                                <h4 class="text-xl font-black flex items-center gap-2 mb-2 text-red-700">
                                    ❌ Chưa đúng rồi!
                                </h4>
                                <p class="font-bold mb-3 text-red-800">Đáp án: <span class="text-xl">{{ correctSentence }}</span></p>
                                <button
                                    @click="activeTab === 'write' ? resetWrite() : resetArrange()"
                                    class="px-5 py-2 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all"
                                >
                                    🔄 Thử lại
                                </button>
                            </div>
                        </div>

                        <!-- ========== ACTION BUTTONS ========== -->
                        <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">
                            <button
                                v-if="(activeTab === 'write' || activeTab === 'arrange' || activeTab === 'listen') && isCorrect === null"
                                @click="activeTab === 'write' ? submitWrite() : submitArrange(false)"
                                :disabled="activeTab === 'write' ? !canSubmitWrite : targetBlocks.length === 0"
                                class="px-8 py-2.5 rounded-xl font-bold transition-all"
                                :class="(activeTab === 'write' ? canSubmitWrite : targetBlocks.length > 0)
                                    ? 'bg-[#aaed5a] text-gray-900 shadow-sm hover:shadow-md hover:bg-[#99d94f] hover:-translate-y-0.5'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                            >
                                ✔ Kiểm tra
                            </button>
                            <Link
                                v-if="isCorrect && next_card_id"
                                :href="route('puzzle.show', { lesson: lesson.id, card: next_card_id })"
                                class="px-8 py-2.5 bg-[#aaed5a] text-gray-900 rounded-xl font-bold shadow-sm hover:shadow-md hover:bg-[#99d94f] hover:-translate-y-0.5 transition-all flex items-center gap-2"
                            >
                                Câu tiếp theo →
                            </Link>
                            <Link
                                v-if="isCorrect && !next_card_id"
                                :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                                class="px-8 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-[#3d7a4a] shadow-sm hover:shadow-md hover:bg-[#eef7e6] hover:-translate-y-0.5 hover:border-[#c4e8a1] transition-all flex items-center gap-2"
                            >
                                🎉 Hoàn thành!
                            </Link>
                        </div>

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
    to   { opacity: 1; transform: translateY(0); }
}
</style>
