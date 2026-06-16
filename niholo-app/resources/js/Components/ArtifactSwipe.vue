<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    artifact: {
        type: Object,
        required: true,
        // { type: 'image' | 'text', content: '...' }
    },
    questions: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: Object,
        required: true,
        // { question_id: selected_option_id }
    }
});

const emit = defineEmits(['update:modelValue', 'submit']);

// Mobile Tabs State
const activeTab = ref('artifact'); // 'artifact' | 'questions'

// Lightbox State
const isLightboxOpen = ref(false);

const selectOption = (questionId, optionId) => {
    const newAnswers = { ...props.modelValue, [questionId]: optionId };
    emit('update:modelValue', newAnswers);
};

const toggleLightbox = () => {
    if (props.artifact.type === 'image') {
        isLightboxOpen.value = !isLightboxOpen.value;
    }
};

const allAnswered = computed(() => {
    if (!props.questions || props.questions.length === 0) return false;
    return props.questions.every(q => props.modelValue[q.id] !== undefined);
});
</script>

<template>
    <div class="h-full w-full flex flex-col md:flex-row bg-gray-50 dark:bg-gray-900 border-x border-b border-gray-200 dark:border-gray-800 relative">
        
        <!-- Mobile Tabs Header -->
        <div class="md:hidden flex border-b-4 border-black bg-white sticky top-16 z-30">
            <button 
                @click="activeTab = 'artifact'"
                class="flex-1 py-4 font-black text-lg transition-colors border-r-4 border-black"
                :class="activeTab === 'artifact' ? 'bg-[#aaed5a] text-black' : 'bg-white text-gray-500 hover:bg-gray-100'"
            >
                📄 Tài liệu
            </button>
            <button 
                @click="activeTab = 'questions'"
                class="flex-1 py-4 font-black text-lg transition-colors flex items-center justify-center gap-2"
                :class="activeTab === 'questions' ? 'bg-niholo-indigo text-white' : 'bg-white text-gray-500 hover:bg-gray-100'"
            >
                📝 Câu hỏi
                <span v-if="allAnswered" class="w-5 h-5 bg-[#aaed5a] text-black rounded-full flex items-center justify-center text-xs">✓</span>
            </button>
        </div>

        <!-- Left Column: Artifact (Sticky on Desktop, Tabbed on Mobile) -->
        <div 
            class="w-full md:w-1/2 lg:w-5/12 bg-gray-100 dark:bg-gray-800 md:border-r border-gray-200 dark:border-gray-700 relative flex flex-col"
            :class="[activeTab === 'artifact' ? 'block' : 'hidden md:flex']"
        >
            <div class="md:sticky md:top-20 h-[calc(100vh-130px)] md:h-[calc(100vh-80px)] p-4 md:p-8 flex flex-col justify-center items-center overflow-auto custom-scrollbar">
                
                <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden relative group">
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tài liệu đọc</span>
                        <button v-if="artifact.type === 'image'" @click="toggleLightbox" class="text-gray-400 hover:text-niholo-indigo md:hidden group-hover:block transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </button>
                    </div>

                    <div class="p-4 md:p-6 flex justify-center items-center bg-gray-50/50 dark:bg-gray-900/50 min-h-[300px]">
                        <img 
                            v-if="artifact.type === 'image'" 
                            :src="artifact.content" 
                            alt="Reading Artifact" 
                            class="max-w-full max-h-[60vh] object-contain cursor-zoom-in rounded border border-gray-200 shadow-sm"
                            @click="toggleLightbox"
                        />
                        <p v-else-if="artifact.type === 'text'" class="font-japanese text-gray-800 dark:text-gray-200 leading-loose text-lg whitespace-pre-line p-4">
                            {{ artifact.content }}
                        </p>
                    </div>
                </div>

                <p class="text-center text-sm text-gray-500 mt-4 hidden md:block" v-if="artifact.type === 'image'">
                    Bấm vào hình ảnh để phóng to
                </p>
            </div>
            
            <!-- Mobile "Switch to Questions" Float Button -->
            <button 
                @click="activeTab = 'questions'"
                class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-niholo-indigo text-white rounded-full flex items-center justify-center shadow-lg border-2 border-black z-40 animate-bounce"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <!-- Right Column: Questions (Scrollable) -->
        <div 
            class="w-full md:w-1/2 lg:w-7/12 bg-white dark:bg-gray-900"
            :class="[activeTab === 'questions' ? 'block' : 'hidden md:block']"
        >
            <div class="p-4 md:p-10 space-y-10">
                <div v-for="(question, qIndex) in questions" :key="question.id" class="question-block">
                    <div class="flex items-start mb-4">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center font-black text-gray-500 mr-4 shrink-0 border border-gray-200">
                            {{ qIndex + 1 }}
                        </div>
                        <p class="font-japanese text-lg font-bold text-gray-800 dark:text-gray-200 leading-relaxed pt-1">
                            {{ question.text }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-3 ml-0 md:ml-12">
                        <label 
                            v-for="(option, oIndex) in question.options" 
                            :key="option.id"
                            class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:-translate-y-0.5"
                            :class="modelValue[question.id] === option.id 
                                ? 'border-black bg-[#aaed5a] shadow-[2px_2px_0px_rgba(0,0,0,1)] text-black' 
                                : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-gray-300'"
                        >
                            <input 
                                type="radio" 
                                :name="`q_${question.id}`" 
                                :value="option.id"
                                :checked="modelValue[question.id] === option.id"
                                @change="selectOption(question.id, option.id)"
                                class="w-5 h-5 text-black border-gray-300 focus:ring-black focus:ring-2"
                            >
                            <span class="ml-4 font-japanese text-lg font-medium" :class="{'font-bold': modelValue[question.id] === option.id}">
                                {{ option.text }}
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button / Next Section Button -->
                <div class="pt-10 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                    <button 
                        @click="emit('submit')"
                        :disabled="!allAnswered"
                        class="px-8 py-4 font-black rounded-xl border-4 border-black transition-all text-xl w-full sm:w-auto"
                        :class="allAnswered 
                            ? 'bg-niholo-indigo text-white shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:translate-x-1 hover:shadow-none' 
                            : 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed'"
                    >
                        Nộp bài & Kiểm tra
                    </button>
                </div>
            </div>
            
            <!-- Mobile "Switch to Artifact" Float Button -->
            <button 
                @click="activeTab = 'artifact'"
                class="md:hidden fixed bottom-6 left-6 w-14 h-14 bg-white text-gray-800 rounded-full flex items-center justify-center shadow-lg border-2 border-gray-300 z-40 opacity-70 hover:opacity-100"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </button>
        </div>

        <!-- Lightbox Overlay -->
        <div v-if="isLightboxOpen && artifact.type === 'image'" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" @click="toggleLightbox">
            <button class="absolute top-6 right-6 text-white bg-white/20 hover:bg-white/40 rounded-full p-2 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img :src="artifact.content" class="max-w-full max-h-[90vh] object-contain rounded-lg" @click.stop />
        </div>

    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #e2e8f0;
  border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
}
.font-japanese {
    font-family: 'Noto Sans JP', sans-serif;
}
</style>
