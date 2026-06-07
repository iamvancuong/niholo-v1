<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    lesson: {
        type: Object,
        required: true,
    }
});

const audioRef = ref(null);
const playingId = ref(null);

const playAudio = (text, id) => {
    if (!text || !window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = 'ja-JP';
    u.rate = 0.85;
    playingId.value = id;
    u.onend = () => { playingId.value = null; };
    window.speechSynthesis.speak(u);
};

</script>

<template>
    <Head :title="'Từ vựng: ' + $t(lesson.title)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })"
                        class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-xl bg-white shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-1 transition-all"
                    >
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </Link>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Từ vựng</p>
                        <h2 class="text-xl font-black text-gray-800">{{ $t(lesson.title) }}</h2>
                    </div>
                </div>

                <div class="flex gap-3">
                    <Link
                        :href="route('study.session', lesson.id)"
                        class="px-5 py-2.5 bg-[#aaed5a] rounded-xl font-bold text-gray-900 shadow-sm hover:shadow-md hover:bg-[#99d94f] hover:-translate-y-0.5 transition-all flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Ôn tập thẻ
                    </Link>
                    <Link
                        v-if="lesson.cards.length > 0"
                        :href="route('puzzle.show', { lesson: lesson.id, card: lesson.cards[0].id })"
                        class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all flex items-center gap-2"
                    >
                        🧩 Ghép câu
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-10 min-h-screen bg-[#f4f7f4] relative">
            <div class="mx-auto max-w-5xl px-4 lg:px-8">

                <!-- Header Banner -->
                <div class="bg-[#eef7e6] border border-[#c4e8a1] rounded-2xl shadow-sm p-6 mb-8 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-[#3d7a4a]">📚 Danh sách từ vựng</h3>
                        <p class="text-gray-600 font-medium mt-1">{{ lesson.cards.length }} từ trong bài này</p>
                    </div>
                    <div class="text-5xl select-none opacity-80">🗾</div>
                </div>

                <!-- Word Cards -->
                <div class="space-y-4">
                    <div
                        v-for="(card, index) in lesson.cards"
                        :key="card.id"
                        class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all overflow-hidden"
                    >
                        <div class="flex flex-col md:flex-row">
                            <!-- Left: Word info -->
                            <div class="md:w-1/3 p-5 flex items-start gap-4 border-b md:border-b-0 md:border-r border-gray-100 bg-[#fcfdfa]">
                                <!-- Number badge -->
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center font-black text-gray-400 text-base shrink-0">
                                    {{ index + 1 }}
                                </div>
                                <div>
                                    <h4 class="text-3xl font-black text-gray-800 mb-1 flex items-center gap-2">
                                        {{ card.front_text }}
                                        <button
                                            @click="playAudio(card.front_text, card.id)"
                                            class="w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-[#3d7a4a] hover:bg-[#eef7e6] transition-all"
                                            :class="{'animate-pulse text-[#3d7a4a] bg-[#eef7e6]': playingId === card.id}"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"/></svg>
                                        </button>
                                    </h4>
                                    <p class="text-base font-bold text-gray-500">{{ card.reading }}</p>
                                </div>
                            </div>

                            <!-- Right: Meaning & Example -->
                            <div class="md:w-2/3 p-5">
                                <p class="text-xl font-bold text-gray-800 mb-3 pb-3 border-b border-gray-100">
                                    {{ $t(card.back_text) }}
                                </p>

                                <div v-if="card.example_japanese" class="bg-gray-50 rounded-xl p-4 group">
                                    <p class="text-gray-700 font-medium mb-1 flex items-start gap-2">
                                        <span class="bg-blue-50 text-blue-600 rounded flex px-1.5 py-0.5 text-[10px] font-bold shrink-0 mt-1 uppercase">JP</span>
                                        <span>{{ card.example_japanese }}</span>
                                        <button
                                            @click="playAudio(card.example_japanese, 'ex_'+card.id)"
                                            class="w-6 h-6 flex items-center justify-center rounded-full text-gray-400 hover:text-[#3d7a4a] hover:bg-[#eef7e6] transition-all shrink-0 mt-0.5 opacity-0 group-hover:opacity-100"
                                            :class="{'opacity-100 animate-pulse text-[#3d7a4a] bg-[#eef7e6]': playingId === 'ex_'+card.id}"
                                        >
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"/></svg>
                                        </button>
                                    </p>
                                    <p class="text-gray-500 text-sm flex gap-2 items-start mt-2">
                                        <span class="bg-gray-100 text-gray-500 rounded flex px-1.5 py-0.5 text-[10px] font-bold shrink-0 mt-0.5 uppercase">VN</span>
                                        {{ $t(card.example_vietnamese) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
