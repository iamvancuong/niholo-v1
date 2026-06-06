<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import confetti from 'canvas-confetti';
import axios from 'axios';
import GrammarCloze from './Components/GrammarCloze.vue';
import KanjiFlashcard from './Components/KanjiFlashcard.vue';
import KanjiExplanationsBlock from './Components/KanjiExplanationsBlock.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    lesson: Object,
    dueCards: Array,
});

const xpPopups = ref([]);
let xpPopupId = 0;

const sessionResults = ref([]);
const sessionSaving = ref(false);
const sessionXpEarned = ref(0);

const showXpPopup = (amount) => {
    // We no longer use this for per-card XP, but keep it in case we need it later
    const id = xpPopupId++;
    xpPopups.value.push({ id, amount });
    setTimeout(() => {
        xpPopups.value = xpPopups.value.filter(p => p.id !== id);
    }, 1500);
};

const page = usePage();
const isGuest = computed(() => !page.props.auth.user);

const getGuestReviews = () => {
    try {
        return JSON.parse(localStorage.getItem('guest_reviews')) || {};
    } catch {
        return {};
    }
};

const saveGuestReview = (cardId, review) => {
    const reviews = getGuestReviews();
    reviews[cardId] = review;
    localStorage.setItem('guest_reviews', JSON.stringify(reviews));
};

const initialCards = () => {
    const now = new Date();
    const guestReviews = getGuestReviews();

    return props.dueCards.filter(item => {
        // Hydrate item.review with localStorage review if available
        let review = item.review;
        if (!review && guestReviews[item.card.id]) {
            review = guestReviews[item.card.id];
        }
        
        // Skip suspended cards
        if (review && review.is_suspended) {
            return false;
        }

        if (review && review.next_review_at) {
            return new Date(review.next_review_at) <= now;
        }
        return true;
    }).map(item => {
        if (guestReviews[item.card.id]) {
            return { ...item, review: guestReviews[item.card.id] };
        }
        return item;
    });
};

const cards = ref(initialCards());
const currentIndex = ref(0);
const isFlipped = ref(false);
const isFinished = ref(cards.value.length === 0);
// Lưu interval dự kiến cho từng nút rating, sẽ cập nhật sau mỗi lần submit
const nextIntervals = ref(null);

const currentCardWrapper = computed(() => {
    return cards.value[currentIndex.value] || null;
});

let audioTimeout = null;
const autoPlayAudio = ref(localStorage.getItem('autoPlayAudio') !== 'false');
const hintLevel = ref(0);

const toggleAudio = () => {
    autoPlayAudio.value = !autoPlayAudio.value;
    localStorage.setItem('autoPlayAudio', autoPlayAudio.value);
};

const showHint = () => {
    if (!isFlipped.value && hintLevel.value < 2) {
        hintLevel.value++;
    }
};

const flipCard = () => {
    if (!isFlipped.value) {
        isFlipped.value = true;
        
        if (autoPlayAudio.value && currentCardWrapper.value) {
            const textToPlay = currentCardWrapper.value.card.front_text;
            clearTimeout(audioTimeout);
            audioTimeout = setTimeout(() => {
                if (isFlipped.value) {
                    playAudio(textToPlay);
                }
            }, 500);
        }
    }
};

const playAudio = (text) => {
    if (!text || !window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'ja-JP';
    utterance.rate = 0.9;
    window.speechSynthesis.speak(utterance);
};

// Format interval cho hiển thị trên nút rating
const formatInterval = (rating) => {
    if (!currentCardWrapper.value || !currentCardWrapper.value.next_intervals) return '';
    return currentCardWrapper.value.next_intervals[rating] || '';
};

const submitRating = (rating) => {
    if (!currentCardWrapper.value) return;
    
    const cardId = currentCardWrapper.value.card.id;
    const currentReviewState = currentCardWrapper.value.review;
    
    // Save to local array instead of sending network request
    let result = {
        card_id: cardId,
        rating: rating,
        duration_ms: 2000,
    };
    if (isGuest.value && currentReviewState) {
        result.current_state = currentReviewState;
    }
    sessionResults.value.push(result);

    // Optimistic UI Update - Move to next card immediately
    isFlipped.value = false;
    hintLevel.value = 0;
    setTimeout(() => {
        currentIndex.value++;
        if (currentIndex.value >= cards.value.length) {
            finishSession();
        }
    }, 150);
};

const suspendCard = () => {
    if (!currentCardWrapper.value) return;
    const cardId = currentCardWrapper.value.card.id;
    sessionResults.value.push({
        card_id: cardId,
        suspend: true,
        duration_ms: 2000,
    });

    isFlipped.value = false;
    hintLevel.value = 0;
    setTimeout(() => {
        currentIndex.value++;
        if (currentIndex.value >= cards.value.length) {
            finishSession();
        }
    }, 150);
};

// Keyboard Shortcuts
const handleKeydown = (e) => {
    if (isFinished.value || sessionSaving.value) return;

    if (e.code === 'Space' || e.code === 'Enter') {
        e.preventDefault();
        if (!isFlipped.value) {
            flipCard();
        }
    } else if (e.code === 'KeyR' || e.key === 'r') {
        // Replay audio
        if (currentCardWrapper.value) {
            playAudio(currentCardWrapper.value.card.front_text);
        }
    } else if (isFlipped.value) {
        if (e.key === '1') submitRating(1);
        if (e.key === '2') submitRating(2);
        if (e.key === '3') submitRating(3);
        if (e.key === '4') submitRating(4);
    } else {
        if (e.code === 'KeyH' || e.key === 'h') showHint();
        if (e.code === 'KeyS' || e.key === 's') suspendCard();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
});

const finishSession = async () => {
    sessionSaving.value = true;
    
    try {
        const response = await axios.post(route('study.finish-session'), {
            results: sessionResults.value
        });
        
        if (isGuest.value && response.data.guest_reviews) {
            Object.entries(response.data.guest_reviews).forEach(([cId, review]) => {
                saveGuestReview(cId, review);
            });
        }
        
        sessionXpEarned.value = response.data.total_xp_earned || 0;
        
        sessionSaving.value = false;
        isFinished.value = true;
        fireConfetti();
        
    } catch (error) {
        console.error("Error finishing session:", error);
        alert("Có lỗi xảy ra khi lưu kết quả bài học!");
        sessionSaving.value = false;
        // Even if it fails, maybe let them finish? For now, we show the finish screen anyway
        isFinished.value = true;
        fireConfetti();
    }
};

const fireConfetti = () => {
    const duration = 3000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

    const randomInRange = (min, max) => Math.random() * (max - min) + min;

    const interval = setInterval(function() {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 50 * (timeLeft / duration);
        confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
        confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
    }, 250);

    // Show guest modal after confetti starts
    if (isGuest.value) {
        setTimeout(() => {
            showGuestModal.value = true;
        }, 1500);
    }
};
</script>

<template>
    <Head :title="'Học bài: ' + $t(lesson.title)" />

    <!-- Minimalistic Study Layout -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col font-japanese relative">
        
        <!-- Top Nav -->
        <header class="p-4 flex items-center justify-between">
            <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" class="text-gray-500 hover:text-niholo-indigo transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </Link>
            
            <div class="w-1/2 max-w-md bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mx-4">
                <div class="bg-gradient-to-r from-niholo-indigo to-niholo-pink h-2.5 rounded-full transition-all duration-500" 
                     :style="{ width: isFinished ? '100%' : `${(currentIndex / cards.length) * 100}%` }"></div>
            </div>
            
            <div class="flex items-center gap-4 text-gray-500 font-bold">
                <button @click="toggleAudio" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition" :class="{ 'text-niholo-indigo': autoPlayAudio }">
                    <svg v-if="autoPlayAudio" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"></path></svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h2.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path></svg>
                </button>
                <span>{{ isFinished ? cards.length : currentIndex }}/{{ cards.length }}</span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col items-center justify-center p-4">
            
            <!-- Saving Screen -->
            <div v-if="sessionSaving" class="text-center animate-pulse flex flex-col items-center">
                <div class="w-16 h-16 border-4 border-indigo-200 border-t-niholo-indigo rounded-full animate-spin mb-6"></div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Đang lưu kết quả...</h2>
                <p class="text-gray-500 mt-2">Vui lòng chờ một chút xíu nhé!</p>
            </div>

            <!-- Finish Screen -->
            <div v-else-if="isFinished" class="text-center animate-fade-in-up flex flex-col items-center">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mb-6 text-white shadow-[0_0_30px_rgba(16,185,129,0.4)]">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Chúc mừng!</h1>
                <p class="text-lg text-gray-500 dark:text-gray-400 mb-6">Bạn đã hoàn thành {{ cards.length }} thẻ của mục tiêu hôm nay.</p>
                
                <div v-if="sessionXpEarned > 0" class="mb-10 transform hover:scale-110 transition cursor-default">
                    <div class="inline-flex items-center gap-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-8 py-3 rounded-full font-black text-3xl shadow-[0_10px_30px_rgba(245,158,11,0.4)] border-4 border-white dark:border-gray-800">
                        <svg class="w-8 h-8 text-yellow-100 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        +{{ sessionXpEarned }} XP
                    </div>
                </div>
                
                <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" class="px-10 py-4 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition text-lg w-full max-w-xs">
                    Tiếp tục học
                </Link>
            </div>

            <div v-else-if="currentCardWrapper" class="w-full max-w-lg w-full flex flex-col items-center">
                
                <!-- Vocabulary UI -->
                <template v-if="currentCardWrapper.card.type === 'vocabulary'">
                    <!-- 3D Card Scene -->
                    <div class="w-full h-72 perspective cursor-pointer shrink-0" @click="flipCard">
                        <!-- Card Container -->
                        <div 
                            class="relative w-full h-full transition-transform duration-500 preserve-3d"
                            :class="{'rotate-y-180': isFlipped}"
                        >
                            <!-- Front (Question) -->
                            <div class="absolute inset-0 backface-hidden glass-panel rounded-3xl shadow-2xl flex flex-col items-center justify-center p-8 text-center border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                                
                                <div class="absolute top-4 right-4 flex gap-2 z-20">
                                    <button @click.stop="showHint" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-500 hover:text-indigo-500 transition" title="Gợi ý (Phím H)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                    <button @click.stop="suspendCard" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-500 hover:text-red-500 transition" title="Đã thuộc / Bỏ qua (Phím S)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </button>
                                </div>

                                <h2 class="relative z-10 text-5xl font-bold text-gray-900 dark:text-white mb-4 drop-shadow-md">
                                    {{ currentCardWrapper.card.front_text }}
                                </h2>

                                <!-- Progressive Hints -->
                                <div class="h-16 flex flex-col items-center justify-center">
                                    <p v-if="hintLevel >= 1" class="text-xl text-gray-600 dark:text-gray-300 font-medium animate-fade-in-up">
                                        {{ currentCardWrapper.card.reading }}
                                    </p>
                                    <p v-if="hintLevel >= 2" class="text-sm text-gray-500 dark:text-gray-400 mt-1 animate-fade-in-up">
                                        {{ $t(currentCardWrapper.card.back_text) }}
                                    </p>
                                </div>

                                <p class="relative z-10 text-gray-500 text-sm mt-4 italic" v-if="!isFlipped">
                                    <span class="hidden md:inline">Nhấn <b>Space</b> để lật thẻ</span>
                                    <span class="inline md:hidden">Chạm để lật thẻ</span>
                                </p>
                            </div>

                        <!-- Back (Answer) -->
                        <div class="absolute inset-0 backface-hidden rotate-y-180 glass-panel rounded-3xl shadow-2xl flex flex-col items-center justify-center p-6 text-center border border-niholo-indigo dark:border-niholo-pink bg-white dark:bg-gray-800 overflow-hidden">
                            <!-- Nút Phát âm thanh thủ công -->
                            <button @click.stop="playAudio(currentCardWrapper.card.front_text)" class="absolute top-4 right-4 p-2 text-niholo-indigo hover:text-niholo-pink transition-colors bg-indigo-50/80 backdrop-blur-sm dark:bg-gray-700/80 rounded-full z-20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"></path></svg>
                            </button>

                            <!-- Answer (Reading) -->
                            <h2 class="relative z-20 text-4xl font-bold text-niholo-indigo dark:text-niholo-pink mb-2 drop-shadow-sm">
                                {{ currentCardWrapper.card.reading }}
                            </h2>
                            <!-- Meaning -->
                            <p class="relative z-20 text-xl font-medium text-gray-800 dark:text-gray-200 mb-4 drop-shadow-sm">
                                {{ $t(currentCardWrapper.card.back_text) }}
                            </p>
                            
                            <!-- Example Sentences (Optional) -->
                            <div v-if="currentCardWrapper.card.example_japanese" class="relative z-20 w-full text-left bg-white/70 backdrop-blur-md dark:bg-gray-800/80 p-4 rounded-xl mt-2 shadow-sm border border-white/50 dark:border-gray-700/50">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ currentCardWrapper.card.example_japanese }}
                                    </p>
                                    <button @click.stop="playAudio(currentCardWrapper.card.example_japanese)" class="ml-2 p-1.5 text-niholo-pink hover:text-pink-600 transition-colors rounded-full hover:bg-pink-50 dark:hover:bg-pink-900/30 flex-shrink-0" title="Nghe ví dụ">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $t(currentCardWrapper.card.example_vietnamese) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- External Image Display (Visible only when flipped, placed below card) -->
                    <transition name="fade-up">
                        <div v-if="isFlipped && currentCardWrapper.card.image_url" class="w-full h-80 mt-6 rounded-3xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700 shrink-0">
                            <img :src="currentCardWrapper.card.image_url" class="w-full h-full object-cover" />
                        </div>
                    </transition>

                    <!-- Kanji Explanations for Vocabulary (Visible only when flipped) -->
                    <transition name="fade-up">
                        <KanjiExplanationsBlock 
                            v-if="isFlipped && currentCardWrapper.card.kanjis && currentCardWrapper.card.kanjis.length > 0"
                            :kanjis="currentCardWrapper.card.kanjis"
                            :isActive="isFlipped"
                        />
                    </transition>
                </template>

                <!-- Grammar UI -->
                <template v-else-if="currentCardWrapper.card.type === 'grammar'">
                    <GrammarCloze 
                        :card="currentCardWrapper.card"
                        @completed="isFlipped = true"
                        @playAudio="playAudio"
                    />
                </template>

                <!-- Kanji UI -->
                <template v-else-if="currentCardWrapper.card.type === 'kanji'">
                    <KanjiFlashcard 
                        :card="currentCardWrapper.card"
                        :isFlipped="isFlipped"
                        @flip="flipCard"
                    />
                </template>

                <!-- Action Buttons -->
                <div v-if="!isFinished" class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-t border-gray-200 dark:border-gray-700 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20 transition-all duration-300">
                    <div class="max-w-2xl mx-auto flex gap-3 justify-center">
                        
                        <button v-if="!isFlipped" @click="flipCard" class="w-full py-4 bg-niholo-indigo hover:bg-indigo-600 text-white font-bold rounded-2xl shadow-lg transform transition active:scale-95 text-lg">
                            Hiện đáp án
                        </button>
                        
                        <template v-else>
                            <button @click="submitRating(1)" class="flex-1 flex flex-col items-center justify-center py-3 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 font-bold rounded-2xl shadow-sm transition active:scale-95">
                                <span class="text-sm opacity-70 mb-1">{{ formatInterval(1) }}</span>
                                <span>Lại</span>
                            </button>
                            <button @click="submitRating(2)" class="flex-1 flex flex-col items-center justify-center py-3 bg-orange-100 hover:bg-orange-200 dark:bg-orange-900/30 dark:hover:bg-orange-900/50 text-orange-700 dark:text-orange-400 font-bold rounded-2xl shadow-sm transition active:scale-95">
                                <span class="text-sm opacity-70 mb-1">{{ formatInterval(2) }}</span>
                                <span>Khó</span>
                            </button>
                            <button @click="submitRating(3)" class="flex-1 flex flex-col items-center justify-center py-3 bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:hover:bg-green-900/50 text-green-700 dark:text-green-400 font-bold rounded-2xl shadow-sm transition active:scale-95 border-2 border-green-500">
                                <span class="text-sm opacity-70 mb-1">{{ formatInterval(3) }}</span>
                                <span>Tốt</span>
                            </button>
                            <button @click="submitRating(4)" class="flex-1 flex flex-col items-center justify-center py-3 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 font-bold rounded-2xl shadow-sm transition active:scale-95">
                                <span class="text-sm opacity-70 mb-1">{{ formatInterval(4) }}</span>
                                <span>Dễ</span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Guest Conversion Modal -->
                <Modal :show="showGuestModal" @close="showGuestModal = false" maxWidth="md">
                    <div class="p-8 text-center relative overflow-hidden bg-white dark:bg-gray-800">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-500 rounded-full blur-3xl opacity-20"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full blur-3xl opacity-20"></div>
                        
                        <div class="relative z-10">
                            <div class="text-6xl mb-4">🎉</div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Bạn học đỉnh quá!</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                Bạn vừa hoàn thành một phiên ôn tập xuất sắc. Hãy tạo tài khoản miễn phí để hệ thống lưu lại điểm số và nhận ngay <strong class="text-orange-500">15 XP</strong> nhé!
                            </p>
                            
                            <div class="flex flex-col gap-3">
                                <Link :href="route('register')" class="w-full py-3 bg-gradient-to-r from-niholo-indigo to-niholo-pink text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform transition hover:-translate-y-1">
                                    Tạo tài khoản lưu điểm ngay
                                </Link>
                                <button @click="showGuestModal = false" class="w-full py-3 text-gray-500 dark:text-gray-400 font-medium hover:text-gray-700 dark:hover:text-gray-200 transition">
                                    Để sau
                                </button>
                            </div>
                        </div>
                    </div>
                </Modal>
                
            </div>
            
            <div v-else class="text-center">
                <p class="text-gray-500">Không có thẻ nào để học.</p>
            </div>

        </main>
    </div>
</template>

<style scoped>
.perspective {
    perspective: 1000px;
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
.animate-fade-in-up {
    animation: fadeInUp 0.5s ease-out forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<style>
/* Global styles for this component */
.xp-pop-enter-active, .xp-pop-leave-active {
    transition: all 1.5s cubic-bezier(0.19, 1, 0.22, 1);
}
.xp-pop-enter-from {
    opacity: 1;
    transform: translateX(-50%) translateY(20px) scale(0.5);
}
.xp-pop-leave-to {
    opacity: 0;
    transform: translateX(-50%) translateY(-150px) scale(1.5);
}
</style>
