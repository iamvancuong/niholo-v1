<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    category: {
        type: String,
        required: true,
    },
    lessons: {
        type: Array,
        required: true,
    },
});

const categoryNames = {
    vocabulary: 'Từ vựng',
    grammar: 'Ngữ pháp',
    kanji: 'Chữ Hán'
};

const page = usePage();
const isGuest = !page.props.auth.user;
const hydratedLessons = ref([...props.lessons]);

onMounted(() => {
    if (isGuest) {
        let guestReviews = {};
        try {
            guestReviews = JSON.parse(localStorage.getItem('guest_reviews')) || {};
        } catch (e) {}

        const now = new Date();

        hydratedLessons.value = hydratedLessons.value.map(lesson => {
            if (lesson.all_card_ids && lesson.all_card_ids.length > 0) {
                let dueCount = 0;
                lesson.all_card_ids.forEach(cardId => {
                    const review = guestReviews[cardId];
                    if (review && review.is_suspended) {
                        return; // skip
                    }
                    if (!review || new Date(review.next_review_at) <= now) {
                        dueCount++;
                    }
                });
                return { ...lesson, due_cards_count: dueCount };
            }
            return lesson;
        });
    }
});
</script>

<template>
    <Head :title="$t(course.name)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('courses.show', course.id)" class="text-gray-500 hover:text-niholo-indigo mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ $t(course.name) }} <span class="text-gray-400 mx-2">/</span> {{ categoryNames[category] }}
                </h2>
            </div>
        </template>

        <div class="py-12 relative overflow-hidden min-h-screen bg-[#f4f7f4]">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Pathway Layout -->
                <div class="relative py-10">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                        <div v-for="(lesson, index) in hydratedLessons" :key="lesson.id" class="relative">
                            <div class="bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                                <div class="relative w-16 h-16 mx-auto mb-4">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-gray-800 text-2xl font-black border-2 border-gray-200 bg-[#fcfdfa] shadow-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <span 
                                        v-if="lesson.due_cards_count > 0"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-gray-800 animate-pulse"
                                    >
                                        {{ lesson.due_cards_count > 99 ? '99+' : lesson.due_cards_count }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-black text-gray-800 mb-2 text-center leading-tight">{{ $t(lesson.title) }}</h3>
                                
                                <div class="text-xs font-bold mb-5 flex justify-center gap-2 flex-wrap">
                                    <span class="bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full text-gray-700">📚 {{ lesson.cards_count }} Thẻ</span>
                                    <span v-if="lesson.due_cards_count > 0" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-full font-bold">
                                        🔥 {{ lesson.due_cards_count }} cần ôn
                                    </span>
                                    <span v-else-if="lesson.cards_count > 0" class="bg-[#eef7e6] text-[#3d7a4a] border border-[#c4e8a1] px-3 py-1.5 rounded-full">
                                        ✓ Đã xong
                                    </span>
                                </div>

                                <div class="flex flex-col space-y-3 w-full">
                                    <!-- Nút Lý thuyết Ngữ pháp -->
                                    <Link 
                                        v-if="category === 'grammar'"
                                        :href="route('grammar.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-[#fcfdfa] border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-[#eef7e6] hover:text-[#3d7a4a] hover:border-[#c4e8a1] transition-all"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            Lý thuyết
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Học Kanji -->
                                    <Link 
                                        v-else-if="category === 'kanji'"
                                        :href="route('kanji.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-[#fcfdfa] border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-[#eef7e6] hover:text-[#3d7a4a] hover:border-[#c4e8a1] transition-all"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                                            Học Kanji
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Từ vựng (Cho Từ vựng) -->
                                    <Link 
                                        v-else-if="category === 'vocabulary'"
                                        :href="route('vocabulary.theory', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-[#fcfdfa] border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-[#eef7e6] hover:text-[#3d7a4a] hover:border-[#c4e8a1] transition-all"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Từ vựng
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Ôn tập thẻ (Flashcard) -->
                                    <Link 
                                        :href="route('study.session', lesson.id)"
                                        class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-bold transition-all"
                                        :class="[lesson.cards_count > 0 ? 'text-gray-900 bg-[#aaed5a] hover:bg-[#99d94f] shadow-sm hover:shadow-md' : 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none']"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            Ôn tập Thẻ
                                            <span v-if="lesson.due_cards_count > 0" class="ml-2 bg-white/40 border border-[#3d7a4a]/20 text-[#3d7a4a] px-2 py-0.5 rounded-full text-xs shadow-sm">
                                                {{ lesson.due_cards_count }}
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>

                                    <!-- Nút Ghép câu -->
                                    <Link 
                                        v-if="lesson.cards && lesson.cards.length > 0"
                                        :href="route('puzzle.show', { lesson: lesson.id, card: lesson.cards[0].id })"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white border-4 border-black rounded-2xl font-black text-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:-translate-y-1 transition-all"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                                            Ghép câu
                                        </div>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
