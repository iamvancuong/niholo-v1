<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-2xl border-4 border-black bg-white px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-black uppercase tracking-widest text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,1)] sm:shadow-[6px_6px_0px_rgba(0,0,0,1)] transition-all hover:-translate-y-1 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] sm:hover:shadow-[8px_8px_0px_rgba(0,0,0,1)] focus:outline-none active:translate-x-[2px] active:translate-y-[2px] active:shadow-none disabled:opacity-50"
    >
        <slot />
    </button>
</template>
