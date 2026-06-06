<template>
    <div class="flex gap-4 items-start w-full">
        <!-- Writer -->
        <div class="flex flex-col items-center shrink-0">
            <div class="bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-2 shadow-inner">
                <div ref="writerContainer" class="w-[80px] h-[80px]"></div>
            </div>
            <button @click.stop="animateStrokes" class="mt-2 px-3 py-1 bg-orange-50 dark:bg-orange-900/30 hover:bg-orange-100 dark:hover:bg-orange-800/50 text-orange-600 dark:text-orange-400 rounded-lg text-xs font-bold transition-colors flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Phát nét
            </button>
        </div>

        <!-- Readings and Mnemonic -->
        <div class="flex-1 flex flex-col gap-3 min-w-0">
            <!-- Sino & Meaning -->
            <div class="flex items-baseline mb-1">
                <span class="text-lg font-bold text-orange-600 dark:text-orange-400 mr-2">{{ $t(kanji.sino_vietnamese) }}</span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t(kanji.meaning) }}</span>
            </div>

            <!-- Readings Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="bg-gray-50 dark:bg-gray-900/50 p-2 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Âm On</h4>
                    <div class="flex flex-wrap gap-1">
                        <span v-for="on in kanji.onyomi" :key="on" class="px-1.5 py-0.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded shadow-sm font-japanese text-sm">{{ on }}</span>
                        <span v-if="!kanji.onyomi || kanji.onyomi.length === 0" class="text-xs text-gray-400 italic">Không có</span>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 p-2 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Âm Kun</h4>
                    <div class="flex flex-wrap gap-1">
                        <span v-for="kun in kanji.kunyomi" :key="kun" class="px-1.5 py-0.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded shadow-sm font-japanese text-sm">{{ kun }}</span>
                        <span v-if="!kanji.kunyomi || kanji.kunyomi.length === 0" class="text-xs text-gray-400 italic">Không có</span>
                    </div>
                </div>
            </div>

            <!-- Mnemonic -->
            <div v-if="kanji.mnemonic" class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-xl border border-yellow-100 dark:border-yellow-800/50">
                <h4 class="text-xs font-bold text-yellow-600 dark:text-yellow-500 flex items-center mb-1">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Gợi ý cách nhớ
                </h4>
                <p class="text-sm text-gray-700 dark:text-gray-300 italic">{{ $t(kanji.mnemonic) }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, nextTick, onUnmounted } from 'vue';
import HanziWriter from 'hanzi-writer';

const props = defineProps({
    kanji: {
        type: Object,
        required: true
    },
    isActive: {
        type: Boolean,
        default: false
    }
});

const writerContainer = ref(null);
let writer = null;

const initWriter = (character) => {
    if (!writerContainer.value) return;
    
    writerContainer.value.innerHTML = '';
    
    // Create writer instance
    writer = HanziWriter.create(writerContainer.value, character, {
        width: 80,
        height: 80,
        padding: 5,
        strokeAnimationSpeed: 1.5,
        delayBetweenStrokes: 100,
        showOutline: true,
        strokeColor: '#f97316', // tailwind orange-500
        radicalColor: '#f97316',
        outlineColor: '#e5e7eb', // tailwind gray-200
    });
};

const animateStrokes = () => {
    if (writer) {
        writer.animateCharacter();
    }
};

watch(() => props.isActive, async (newVal) => {
    if (newVal && props.kanji) {
        await nextTick();
        if (!writer) {
            initWriter(props.kanji.character);
        }
        setTimeout(() => animateStrokes(), 500);
    }
}, { immediate: true });

onUnmounted(() => {
    writer = null;
});
</script>
