<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-xl border-4 border-black bg-white px-3 py-2 sm:px-4 sm:py-3 text-gray-900 shadow-[2px_2px_0px_rgba(0,0,0,1)] sm:shadow-[4px_4px_0px_rgba(0,0,0,1)] transition-all focus:border-black focus:ring-0 focus:-translate-y-0.5 focus:shadow-[4px_4px_0px_rgba(0,0,0,1)] sm:focus:shadow-[6px_6px_0px_rgba(0,0,0,1)]"
        v-model="model"
        ref="input"
    />
</template>
