<template>
    <div v-if="kanjis && kanjis.length > 0" class="w-full mt-6 bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-orange-100 dark:border-orange-900/30 p-5 flex flex-col gap-4">
        
        <!-- Tabs for multiple kanjis -->
        <div v-if="kanjis.length > 1" class="flex space-x-2 overflow-x-auto pb-2 mb-2 scrollbar-hide border-b border-gray-100 dark:border-gray-700">
            <button 
                v-for="(kanji, index) in kanjis" 
                :key="kanji.id"
                @click="activeTabIndex = index"
                class="px-4 py-2 rounded-t-xl font-bold text-lg transition-colors whitespace-nowrap"
                :class="activeTabIndex === index 
                    ? 'text-orange-600 dark:text-orange-400 border-b-2 border-orange-500' 
                    : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
            >
                {{ kanji.character }}
            </button>
        </div>

        <!-- Render the active Kanji Explanation -->
        <div class="w-full relative">
            <template v-for="(kanji, index) in kanjis" :key="kanji.id">
                <KanjiExplanation 
                    v-show="activeTabIndex === index"
                    :kanji="kanji" 
                    :isActive="isActive && activeTabIndex === index" 
                />
            </template>
        </div>

    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import KanjiExplanation from './KanjiExplanation.vue';

const props = defineProps({
    kanjis: {
        type: Array,
        required: true
    },
    isActive: {
        type: Boolean,
        default: false
    }
});

const activeTabIndex = ref(0);

// Reset tab when input kanjis change
watch(() => props.kanjis, () => {
    activeTabIndex.value = 0;
});
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
