<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    exam: {
        type: Object,
        required: true,
    },
    totalDuration: {
        type: Number,
        required: true,
    }
});

const sectionNames = {
    'moji_goi': 'Từ vựng - Chữ Hán',
    'bunpou_dokkai': 'Ngữ pháp - Đọc hiểu',
    'choukai': 'Nghe hiểu'
};

const activeTab = ref(0);
const timeLeft = ref(props.totalDuration * 60); // in seconds
let timerInterval = null;

const form = useForm({
    answers: {} // { questionId: optionId }
});

const formattedTime = computed(() => {
    const m = Math.floor(timeLeft.value / 60).toString().padStart(2, '0');
    const s = (timeLeft.value % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
});

const isLowTime = computed(() => timeLeft.value <= 300); // <= 5 minutes

const startTimer = () => {
    timerInterval = setInterval(() => {
        if (timeLeft.value > 0) {
            timeLeft.value--;
        } else {
            clearInterval(timerInterval);
            submitExam();
        }
    }, 1000);
};

const submitExam = () => {
    clearInterval(timerInterval);
    form.post(route('exams.submit', props.exam.id), {
        onBefore: () => confirm('Bạn có chắc chắn muốn nộp bài?'),
    });
};

onMounted(() => {
    startTimer();
    
    // Warn before leaving page
    window.addEventListener('beforeunload', handleBeforeUnload);
});

onUnmounted(() => {
    clearInterval(timerInterval);
    window.removeEventListener('beforeunload', handleBeforeUnload);
});

const handleBeforeUnload = (e) => {
    e.preventDefault();
    e.returnValue = '';
};

const selectAnswer = (questionId, optionId) => {
    form.answers[questionId] = optionId;
};

// Organize questions by mondai
const getMondaisForSection = (section) => {
    const mondais = {};
    section.questions.forEach(q => {
        if (!mondais[q.mondai_number]) {
            mondais[q.mondai_number] = {
                number: q.mondai_number,
                instruction: q.instruction,
                passage: q.passage,
                questions: []
            };
        }
        // If a question has a passage, override the mondai passage (simplification)
        if (q.passage) mondais[q.mondai_number].passage = q.passage;
        mondais[q.mondai_number].questions.push(q);
    });
    
    return Object.values(mondais).sort((a, b) => a.number - b.number);
};

</script>

<template>
    <Head :title="`Làm bài: ${exam.title}`" />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <!-- Sticky Header -->
        <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-pink-100 dark:from-indigo-900/40 dark:to-pink-900/40 flex items-center justify-center font-bold text-transparent bg-clip-text bg-gradient-to-r from-niholo-indigo to-niholo-pink">
                        {{ exam.level }}
                    </div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white hidden sm:block truncate w-64 md:w-auto">{{ exam.title }}</h1>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Timer -->
                    <div class="flex items-center space-x-2 font-mono text-xl md:text-2xl font-bold"
                         :class="isLowTime ? 'text-red-600 dark:text-red-400 animate-pulse' : 'text-gray-800 dark:text-gray-200'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ formattedTime }}</span>
                    </div>

                    <button 
                        @click="submitExam"
                        :disabled="form.processing"
                        class="px-6 py-2 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all active:scale-95 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Đang nộp...' : 'Nộp bài' }}
                    </button>
                </div>
            </div>

            <!-- Tabs -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex space-x-1 md:space-x-8 overflow-x-auto custom-scrollbar pb-1">
                    <button
                        v-for="(section, index) in exam.sections"
                        :key="section.id"
                        @click="activeTab = index"
                        class="whitespace-nowrap py-3 px-1 md:px-4 border-b-4 font-semibold text-sm md:text-base transition-colors"
                        :class="activeTab === index 
                            ? 'border-niholo-indigo text-niholo-indigo' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:border-gray-300'"
                    >
                        {{ sectionNames[section.type] || section.type }}
                        <span class="ml-2 text-xs py-0.5 px-2 rounded-full"
                              :class="activeTab === index ? 'bg-indigo-100 dark:bg-indigo-900/50 text-niholo-indigo' : 'bg-gray-100 dark:bg-gray-700 text-gray-500'">
                            {{ section.questions.length }} câu
                        </span>
                    </button>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow py-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div v-for="(section, index) in exam.sections" :key="section.id" v-show="activeTab === index">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ sectionNames[section.type] || section.type }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">Thời gian khuyên dùng: {{ section.duration_minutes }} phút</p>
                    </div>

                    <!-- Lặp qua các Mondai trong Section -->
                    <div v-for="mondai in getMondaisForSection(section)" :key="mondai.number" class="mb-12">
                        <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-4 rounded-xl border border-indigo-100 dark:border-indigo-800/30 mb-6">
                            <h3 class="text-lg font-bold text-niholo-indigo mb-2">問題 {{ mondai.number }}</h3>
                            <p class="text-gray-800 dark:text-gray-200 leading-relaxed font-japanese text-lg">{{ mondai.instruction }}</p>
                        </div>

                        <!-- Đoạn văn đọc hiểu nếu có -->
                        <div v-if="mondai.passage" class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <p class="whitespace-pre-line text-gray-800 dark:text-gray-200 leading-loose font-japanese text-lg">{{ mondai.passage }}</p>
                        </div>

                        <div class="space-y-8">
                            <div v-for="(question, qIdx) in mondai.questions" :key="question.id" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <div class="flex">
                                    <div class="font-bold text-gray-400 mr-4 mt-1">{{ qIdx + 1 }}.</div>
                                    <div class="flex-grow">
                                        <!-- Text câu hỏi -->
                                        <p v-if="question.text" class="text-lg text-gray-900 dark:text-gray-100 font-japanese leading-relaxed mb-6">
                                            {{ question.text }}
                                        </p>
                                        
                                        <!-- Hình ảnh nếu có -->
                                        <div v-if="question.image_url" class="mb-6">
                                            <img :src="question.image_url" class="max-w-full rounded-lg border border-gray-200 dark:border-gray-700" alt="Question Image" />
                                        </div>

                                        <!-- Options -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <label 
                                                v-for="option in question.options_json" 
                                                :key="option.id"
                                                class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                                :class="form.answers[question.id] === option.id 
                                                    ? 'border-niholo-indigo bg-indigo-50 dark:bg-indigo-900/20 ring-2 ring-niholo-indigo ring-opacity-50' 
                                                    : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                                            >
                                                <input 
                                                    type="radio" 
                                                    :name="`q_${question.id}`" 
                                                    :value="option.id" 
                                                    @change="selectAnswer(question.id, option.id)"
                                                    :checked="form.answers[question.id] === option.id"
                                                    class="w-5 h-5 text-niholo-indigo border-gray-300 focus:ring-niholo-indigo dark:bg-gray-700 dark:border-gray-600"
                                                >
                                                <span class="ml-3 text-gray-800 dark:text-gray-200 font-japanese text-lg">{{ option.id }}. {{ option.text }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Nút chuyển Tab / Nộp bài ở cuối -->
                    <div class="mt-12 flex justify-end">
                        <button v-if="index < exam.sections.length - 1" @click="activeTab = index + 1" class="px-6 py-3 bg-white dark:bg-gray-800 border-2 border-niholo-indigo text-niholo-indigo font-bold rounded-xl hover:bg-indigo-50 transition-colors">
                            Sang phần tiếp theo &rarr;
                        </button>
                        <button v-else @click="submitExam" class="px-8 py-3 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Hoàn thành & Nộp bài
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  height: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #475569;
}
.font-japanese {
    font-family: 'Noto Sans JP', sans-serif;
}
</style>
