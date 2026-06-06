<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
    card: Object,
});

const emit = defineEmits(['completed', 'playAudio']);

// Decode example_blocks_json if it's a string
const blocksData = computed(() => {
    let data = props.card.example_blocks_json;
    if (typeof data === 'string') {
        data = JSON.parse(data);
    }
    return data;
});

import { marked } from 'marked';
marked.setOptions({
    breaks: true,
    gfm: true
});

const parseMarkdown = (text) => {
    if (!text) return '';
    return marked.parse(text);
};

const blocks = computed(() => blocksData.value?.blocks || []);
const correctOrder = computed(() => blocksData.value?.correct_order || []);

// State
const slots = ref([]); // Lỗ trống cần điền
const tray = ref([]);  // Các mảnh ghép ở dưới khay
const isCompleted = ref(false);

const initialize = () => {
    slots.value = [];
    tray.value = [];
    isCompleted.value = false;

    // Build the sentence slots
    // We iterate over correctOrder to build the sentence structure
    // But wait, the sentence structure might be defined by correctOrder.
    // Actually, correctOrder tells us the exact sequence of blocks.
    // For 'vocabulary' types, they are pre-filled.
    // For 'particle' / 'grammar_ending', they are empty slots.
    
    // First, let's create the slots based on correctOrder
    correctOrder.value.forEach(blockId => {
        const block = blocks.value.find(b => b.id === blockId);
        if (!block) return;

        if (block.type === 'vocabulary') {
            slots.value.push({
                id: 'slot_' + block.id,
                expectedBlockId: block.id,
                filledBlock: block, // Pre-filled
                isFixed: true,
            });
        } else {
            slots.value.push({
                id: 'slot_' + block.id,
                expectedBlockId: block.id,
                filledBlock: null, // Empty slot
                isFixed: false,
            });
            // Add this block to tray
            tray.value.push(block);
        }
    });

    // Add distractors to tray
    blocks.value.filter(b => b.type === 'distractor').forEach(distractor => {
        tray.value.push(distractor);
    });
    
    // Shuffle tray (simple shuffle)
    tray.value.sort(() => Math.random() - 0.5);
};

watch(() => props.card, initialize, { immediate: true });

// Interaction: Tap to fill / tap to remove
const tapTrayBlock = (block) => {
    if (isCompleted.value) return;
    
    // Find first empty slot
    const emptySlot = slots.value.find(s => !s.isFixed && !s.filledBlock);
    if (emptySlot) {
        emptySlot.filledBlock = block;
        tray.value = tray.value.filter(b => b.id !== block.id);
        checkCompletion();
    }
};

const tapSlot = (slot) => {
    if (isCompleted.value) return;
    if (slot.isFixed || !slot.filledBlock) return;
    
    // Move block back to tray
    tray.value.push(slot.filledBlock);
    slot.filledBlock = null;
};

const checkCompletion = () => {
    // Check if all non-fixed slots are filled
    const allFilled = slots.value.every(s => s.isFixed || s.filledBlock);
    if (!allFilled) return;

    // Check correctness
    const isCorrect = slots.value.every(s => s.isFixed || s.filledBlock.id === s.expectedBlockId);
    if (isCorrect) {
        isCompleted.value = true;
        // Emit completion so parent can show rating buttons
        emit('completed');
        emit('playAudio', props.card.example_japanese);
    } else {
        // If wrong, shake animation or auto-return incorrect blocks
        // For now, auto return all non-fixed
        setTimeout(() => {
            slots.value.filter(s => !s.isFixed).forEach(s => {
                if (s.filledBlock) {
                    tray.value.push(s.filledBlock);
                    s.filledBlock = null;
                }
            });
            // Simple shuffle again
            tray.value.sort(() => Math.random() - 0.5);
        }, 500);
    }
};

</script>

<template>
    <div class="w-full flex flex-col items-center justify-center p-6 glass-panel rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        
        <!-- Grammar Point Hint (Only shown after completed) -->
        <div v-if="isCompleted && card.grammar_point" class="w-full mb-8 flex flex-col items-center animate-fade-in">
            <span class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-niholo-indigo dark:text-indigo-300 text-sm font-semibold rounded-full border border-indigo-100 dark:border-indigo-800 shadow-sm mb-4">
                📚 {{ $t(card.grammar_point.title) }}
            </span>
            
            <div class="w-full bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm prose dark:prose-invert grammar-explanation" v-html="parseMarkdown($t(card.grammar_point.cure_dolly_explanation))">
            </div>
        </div>

        <!-- Meaning Hint & Audio -->
        <div class="flex items-center justify-center gap-4 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 text-center">
                {{ $t(card.front_text) }}
            </h3>
            
            <button 
                v-if="isCompleted && card.example_japanese" 
                @click="emit('playAudio', card.example_japanese)" 
                class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-niholo-indigo dark:text-indigo-400 rounded-full hover:bg-indigo-100 dark:hover:bg-indigo-800 transition shadow-sm active:scale-95 animate-fade-in"
                title="Nghe lại"
            >
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
            </button>
        </div>

        <!-- Sentence Area -->
        <div class="flex flex-wrap justify-center items-end gap-2 mb-10 min-h-[80px]">
            <div 
                v-for="(slot, index) in slots" 
                :key="slot.id"
                class="flex flex-col items-center"
            >
                <!-- Furigana space (only for pre-filled blocks typically) -->
                <span class="text-xs text-gray-500 h-4 mb-1">
                    {{ slot.filledBlock?.furigana || '' }}
                </span>
                
                <!-- The Block or Slot -->
                <div 
                    @click="tapSlot(slot)"
                    class="h-12 min-w-[3rem] px-3 flex items-center justify-center rounded-xl text-xl font-bold transition-all"
                    :class="[
                        slot.isFixed ? 'text-gray-900 dark:text-white border-b-2 border-transparent' : 
                        slot.filledBlock ? 'bg-niholo-indigo text-white cursor-pointer hover:bg-indigo-600 shadow-md transform scale-105' : 'border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-transparent'
                    ]"
                >
                    {{ slot.filledBlock ? slot.filledBlock.text : '___' }}
                </div>
            </div>
        </div>

        <!-- Tray Area -->
        <div v-if="!isCompleted" class="w-full pt-6 border-t border-gray-100 dark:border-gray-700 min-h-[100px] animate-fade-in">
            <div class="flex flex-wrap justify-center gap-3">
                <transition-group name="list">
                    <button 
                        v-for="block in tray" 
                        :key="block.id"
                        @click="tapTrayBlock(block)"
                        class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 shadow-sm rounded-xl text-lg font-bold text-niholo-indigo dark:text-niholo-pink hover:bg-indigo-50 dark:hover:bg-gray-600 transition transform hover:-translate-y-1"
                    >
                        {{ block.text }}
                    </button>
                </transition-group>
            </div>
        </div>
        
    </div>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.3s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(20px) scale(0.9);
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scoped styles for dynamically injected markdown content */
:deep(.grammar-explanation p) {
    margin-bottom: 0.5rem;
}
:deep(.grammar-explanation strong) {
    color: #4f46e5;
}
.dark :deep(.grammar-explanation strong) {
    color: #ec4899;
}
</style>
