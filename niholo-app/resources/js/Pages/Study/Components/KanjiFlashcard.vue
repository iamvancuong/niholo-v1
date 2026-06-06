<script setup>
import { ref, computed, watch, nextTick } from 'vue';
import HanziWriter from 'hanzi-writer';

const props = defineProps({
    card: Object,
    isFlipped: Boolean
});

const emit = defineEmits(['flip']);

const tapCard = () => {
    emit('flip');
};

import KanjiExplanationsBlock from './KanjiExplanationsBlock.vue';

const kanjis = computed(() => {
    return props.card.kanjis || [];
});
</script>

<template>
    <div class="w-full flex flex-col items-center">
        <!-- 3D Card Scene for Kanji -->
        <div class="w-full h-72 perspective cursor-pointer shrink-0" @click="tapCard">
            <!-- Card Container -->
            <div 
                class="relative w-full h-full transition-transform duration-500 preserve-3d"
                :class="{'rotate-y-180': isFlipped}"
            >
                <!-- Front (Question - Japanese Kanji) -->
                <div class="absolute inset-0 backface-hidden glass-panel rounded-3xl shadow-2xl flex flex-col items-center justify-center p-8 text-center border border-orange-200 dark:border-orange-900/50 bg-white dark:bg-gray-800 overflow-hidden">
                    <h2 class="relative z-10 text-8xl font-japanese font-bold text-gray-900 dark:text-white mb-4 drop-shadow-md">
                        {{ card.front_text }}
                    </h2>
                    <p class="relative z-10 text-gray-500 text-sm mt-4 italic" v-if="!isFlipped">Chạm để lật thẻ Kanji</p>
                </div>

                <!-- Back (Answer - Meaning & Readings) -->
                <div class="absolute inset-0 backface-hidden rotate-y-180 glass-panel rounded-3xl shadow-2xl flex flex-col items-center justify-center p-6 text-center border border-orange-500 dark:border-orange-500 bg-white dark:bg-gray-800 overflow-hidden">
                    <h2 class="relative z-20 text-4xl font-bold text-orange-500 dark:text-orange-400 mb-2 drop-shadow-sm">
                        {{ $t(card.back_text.split('-')[0].trim()) }}
                    </h2>
                    <p class="relative z-20 text-xl font-medium text-gray-800 dark:text-gray-200 drop-shadow-sm">
                        {{ $t(card.back_text.split('-')[1].trim()) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Explanation Section (Visible when flipped) -->
        <transition name="fade-up">
            <KanjiExplanationsBlock 
                v-if="isFlipped && kanjis.length > 0"
                :kanjis="kanjis"
                :isActive="isFlipped"
            />
        </transition>
    </div>
</template>

<style scoped>
.font-japanese {
    font-family: 'Noto Sans JP', sans-serif;
}
.perspective {
    perspective: 1000px;
}
.preserve-3d {
    transform-style: preserve-3d;
}
.rotate-y-180 {
    transform: rotateY(180deg);
}
.backface-hidden {
    backface-visibility: hidden;
}
.fade-up-enter-active,
.fade-up-leave-active {
    transition: all 0.5s ease-out;
}
.fade-up-enter-from,
.fade-up-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
</style>
