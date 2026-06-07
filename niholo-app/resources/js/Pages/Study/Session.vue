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
        // For authenticated users: trust the server's due card list entirely.
        // The server already filters by next_review_at and is_suspended from the DB.
        // Do NOT apply localStorage filtering for logged-in users as it causes
        // mismatch when a user previously studied as a guest.
        if (!isGuest.value) {
            // Only skip if item.review from server explicitly marks as suspended
            if (item.review && item.review.is_suspended) {
                return false;
            }
            return true;
        }

        // For guests: hydrate review from localStorage and apply due-date filtering
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
        // Only hydrate from localStorage for guests
        if (!isGuest.value) return item;
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
    
    let payload = {
        rating: rating,
        duration_ms: 2000,
    };
    if (isGuest.value && currentReviewState) {
        payload.current_state = currentReviewState;
    }

    // Optimistic UI Update
    isFlipped.value = false;
    hintLevel.value = 0;

    // Fire API request in background
    axios.post(route('review.store', cardId), payload)
        .then(response => {
            if (response.data.success) {
                if (response.data.xp_earned > 0) {
                    showXpPopup(response.data.xp_earned);
                    sessionXpEarned.value += response.data.xp_earned;
                }
                if (isGuest.value && response.data.review) {
                    saveGuestReview(cardId, response.data.review);
                }
            }
        })
        .catch(error => {
            if (error.response && (error.response.status === 419 || error.response.status === 401)) {
                alert("Phiên đăng nhập của bạn đã hết hạn. Vui lòng đăng nhập lại để tiếp tục học!");
                window.location.href = '/login';
            } else {
                console.error("Error saving review:", error);
            }
        });

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

    isFlipped.value = false;
    hintLevel.value = 0;

    axios.post(route('review.store', cardId), { suspend: true, duration_ms: 2000 })
        .then(response => {
            if (response.data.success && isGuest.value && response.data.review) {
                saveGuestReview(cardId, response.data.review);
            }
        })
        .catch(error => {
            if (error.response && (error.response.status === 419 || error.response.status === 401)) {
                alert("Phiên đăng nhập của bạn đã hết hạn. Vui lòng đăng nhập lại để tiếp tục học!");
                window.location.href = '/login';
            }
        });

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

    <!-- Neo-brutalism Study Layout -->
    <div class="min-h-screen bg-[#f4f7f4] flex flex-col font-japanese relative z-10">
        
        <!-- Top Nav -->
        <header class="p-4 sm:p-6 flex items-center justify-between w-full max-w-5xl mx-auto">
            <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" 
                  class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-xl bg-white shadow-sm hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 transition-all shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </Link>
            
            <div class="flex-1 mx-4 sm:mx-8 relative">
                <div class="h-4 w-full bg-gray-100 rounded-full overflow-hidden shadow-inner border border-gray-200">
                    <div class="bg-[#aaed5a] h-full transition-all duration-500" 
                         :style="{ width: isFinished ? '100%' : `${(currentIndex / cards.length) * 100}%` }"></div>
                </div>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <button @click="toggleAudio" 
                        class="w-10 h-10 hidden sm:flex items-center justify-center border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all" 
                        :class="autoPlayAudio ? 'bg-[#eef7e6] text-[#3d7a4a] border-[#c4e8a1]' : 'bg-white text-gray-400'">
                    <svg v-if="autoPlayAudio" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"></path></svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h2.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path></svg>
                </button>
                <div class="px-3 py-1.5 bg-white border border-gray-200 rounded-xl shadow-sm font-bold text-gray-600 text-sm">
                    {{ isFinished ? cards.length : currentIndex }}/{{ cards.length }}
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col items-center justify-center p-4 w-full pb-32">
            
            <!-- Saving Screen -->
            <div v-if="sessionSaving" class="text-center flex flex-col items-center p-8 bg-white border border-gray-100 rounded-3xl shadow-lg max-w-sm w-full">
                <div class="w-12 h-12 border-4 border-gray-100 border-t-[#3d7a4a] rounded-full animate-spin mb-4"></div>
                <h2 class="text-2xl font-black text-gray-800">Đang lưu kết quả...</h2>
                <p class="text-gray-500 font-medium mt-1">Vui lòng chờ một chút xíu nhé!</p>
            </div>

            <!-- Finish Screen -->
            <div v-else-if="isFinished" class="text-center animate-fade-in-up flex flex-col items-center bg-white border border-gray-100 rounded-3xl shadow-lg p-10 max-w-md w-full">
                <div class="w-24 h-24 mx-auto bg-[#eef7e6] border-4 border-white ring-2 ring-[#c4e8a1] rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-12 h-12 text-[#3d7a4a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-gray-800 mb-2">Chúc mừng!</h1>
                <p class="text-base font-bold text-gray-500 mb-6">Bạn đã hoàn thành {{ cards.length }} thẻ.</p>
                
                <div v-if="sessionXpEarned > 0" class="mb-10 transform hover:-translate-y-1 transition cursor-default">
                    <div class="inline-flex items-center gap-3 bg-[#fff8e7] px-6 py-2.5 rounded-xl font-black text-2xl border border-[#f5c842] text-[#e8a820] shadow-sm">
                        🔥 +{{ sessionXpEarned }} XP
                    </div>
                </div>
                
                <Link :href="route('lessons.index', { course: lesson.course_id, category: lesson.category })" 
                      class="px-8 py-3.5 bg-[#aaed5a] text-gray-900 font-bold rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:bg-[#99d94f] transition-all text-lg w-full">
                    Tiếp tục học
                </Link>
            </div>

            <!-- Card UI -->
            <div v-else-if="currentCardWrapper" class="w-full max-w-lg flex flex-col items-center">
                
                <!-- Vocabulary UI -->
                <template v-if="currentCardWrapper.card.type === 'vocabulary'">
                    <!-- 3D Card Scene -->
                    <div class="w-full h-80 perspective cursor-pointer shrink-0 group" @click="flipCard">
                        <!-- Card Container -->
                        <div 
                            class="relative w-full h-full transition-transform duration-500 preserve-3d"
                            :class="{'rotate-y-180': isFlipped}"
                        >
                            <!-- Front (Question) -->
                            <div class="absolute inset-0 backface-hidden rounded-3xl flex flex-col items-center justify-center p-8 text-center border border-gray-200 bg-white shadow-md overflow-hidden">
                                
                                <div class="absolute top-4 right-4 flex gap-2 z-20">
                                    <button @click.stop="showHint" class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-500 rounded-full hover:bg-gray-100 transition-all hover:text-gray-800" title="Gợi ý (Phím H)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                    <button @click.stop="suspendCard" class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-500 rounded-full hover:bg-red-50 hover:text-red-500 transition-all" title="Đã thuộc / Bỏ qua (Phím S)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </button>
                                </div>

                                <h2 class="relative z-10 text-6xl font-black text-gray-800 mb-4">
                                    {{ currentCardWrapper.card.front_text }}
                                </h2>

                                <!-- Progressive Hints -->
                                <div class="h-16 flex flex-col items-center justify-center">
                                    <p v-if="hintLevel >= 1" class="text-2xl font-bold text-gray-400 animate-fade-in-up">
                                        {{ currentCardWrapper.card.reading }}
                                    </p>
                                    <p v-if="hintLevel >= 2" class="text-lg font-medium text-gray-300 mt-1 animate-fade-in-up">
                                        {{ $t(currentCardWrapper.card.back_text) }}
                                    </p>
                                </div>

                                <p class="absolute bottom-6 font-medium text-gray-300 text-xs italic" v-if="!isFlipped">
                                    <span class="hidden md:inline">Nhấn <b>Space</b> để lật thẻ</span>
                                    <span class="inline md:hidden">Chạm để lật thẻ</span>
                                </p>
                            </div>

                        <!-- Back (Answer) -->
                        <div class="absolute inset-0 backface-hidden rotate-y-180 rounded-3xl flex flex-col items-center justify-center p-6 text-center border border-[#c4e8a1] bg-[#fcfdfa] shadow-md overflow-hidden">
                            <!-- Nút Phát âm thanh thủ công -->
                            <button @click.stop="playAudio(currentCardWrapper.card.front_text)" class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-500 rounded-full hover:bg-[#eef7e6] hover:text-[#3d7a4a] transition-all z-20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5 10v4a2 2 0 002 2h2l4 4V4L9 8H7a2 2 0 00-2 2z"></path></svg>
                            </button>

                            <!-- Answer (Reading) -->
                            <h2 class="relative z-20 text-5xl font-black text-gray-800 mb-2">
                                {{ currentCardWrapper.card.reading }}
                            </h2>
                            <!-- Meaning -->
                            <p class="relative z-20 text-xl font-bold text-[#3d7a4a] mb-4 pb-4 border-b border-gray-100 w-full">
                                {{ $t(currentCardWrapper.card.back_text) }}
                            </p>
                            
                            <!-- Example Sentences -->
                            <div v-if="currentCardWrapper.card.example_japanese" class="relative z-20 w-full text-left bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                                <div class="flex items-start justify-between mb-1 gap-2">
                                    <p class="text-sm font-bold text-gray-700 leading-tight">
                                        <span class="bg-blue-50 text-blue-600 rounded flex px-1.5 py-0.5 text-[10px] font-black shrink-0 mr-1 align-middle uppercase inline-block">JP</span>
                                        {{ currentCardWrapper.card.example_japanese }}
                                    </p>
                                    <button @click.stop="playAudio(currentCardWrapper.card.example_japanese)" class="w-6 h-6 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full hover:bg-gray-100 transition-all shrink-0" title="Nghe ví dụ">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                                <p class="text-xs font-medium text-gray-500 mt-1">
                                    <span class="bg-gray-100 text-gray-500 rounded flex px-1.5 py-0.5 text-[10px] font-black shrink-0 mr-1 align-middle uppercase inline-block">VN</span>
                                    {{ $t(currentCardWrapper.card.example_vietnamese) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- External Image Display -->
                    <transition name="fade-up">
                        <div v-if="isFlipped && currentCardWrapper.card.image_url" class="w-full h-80 mt-6 rounded-2xl border border-gray-200 overflow-hidden shadow-sm bg-white shrink-0">
                            <img :src="currentCardWrapper.card.image_url" class="w-full h-full object-cover" />
                        </div>
                    </transition>

                    <!-- Kanji Explanations -->
                    <transition name="fade-up">
                        <KanjiExplanationsBlock 
                            v-if="isFlipped && currentCardWrapper.card.kanjis && currentCardWrapper.card.kanjis.length > 0"
                            :kanjis="currentCardWrapper.card.kanjis"
                            :isActive="isFlipped"
                            class="mt-6 w-full"
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
            </div>
            
            <div v-else class="text-center p-10 bg-white border-4 border-black rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)]">
                <p class="text-2xl font-black text-black">Không có thẻ nào để học.</p>
            </div>

        </main>

        <!-- Action Buttons (Bottom Fixed) -->
        <div v-if="!isFinished && currentCardWrapper" class="fixed bottom-0 left-0 right-0 p-4 md:p-6 bg-white/90 backdrop-blur-md border-t border-gray-200 z-30 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <div class="max-w-3xl mx-auto flex gap-3 justify-center">
                
                <button v-if="!isFlipped" @click="flipCard" class="w-full py-4 bg-[#aaed5a] text-gray-900 font-bold text-xl rounded-xl shadow-sm hover:shadow-md hover:bg-[#99d94f] hover:-translate-y-0.5 transition-all">
                    HIỆN ĐÁP ÁN
                </button>
                
                <template v-else>
                    <button @click="submitRating(1)" class="flex-1 flex flex-col items-center justify-center py-3 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-100 hover:-translate-y-0.5 transition-all">
                        <span class="text-[10px] bg-white rounded px-1.5 py-0.5 mb-0.5 opacity-80">{{ formatInterval(1) || '1m' }}</span>
                        <span class="text-base">LẠI</span>
                    </button>
                    <button @click="submitRating(2)" class="flex-1 flex flex-col items-center justify-center py-3 bg-orange-50 text-orange-600 font-bold rounded-xl border border-orange-100 hover:bg-orange-100 hover:-translate-y-0.5 transition-all">
                        <span class="text-[10px] bg-white rounded px-1.5 py-0.5 mb-0.5 opacity-80">{{ formatInterval(2) || '10m' }}</span>
                        <span class="text-base">KHÓ</span>
                    </button>
                    <button @click="submitRating(3)" class="flex-1 flex flex-col items-center justify-center py-3 bg-[#eef7e6] text-[#3d7a4a] font-bold rounded-xl border border-[#c4e8a1] hover:bg-[#e0f5c4] hover:-translate-y-0.5 transition-all">
                        <span class="text-[10px] bg-white rounded px-1.5 py-0.5 mb-0.5 opacity-80">{{ formatInterval(3) || '1d' }}</span>
                        <span class="text-base">TỐT</span>
                    </button>
                    <button @click="submitRating(4)" class="flex-1 flex flex-col items-center justify-center py-3 bg-blue-50 text-blue-600 font-bold rounded-xl border border-blue-100 hover:bg-blue-100 hover:-translate-y-0.5 transition-all">
                        <span class="text-[10px] bg-white rounded px-1.5 py-0.5 mb-0.5 opacity-80">{{ formatInterval(4) || '4d' }}</span>
                        <span class="text-base">DỄ</span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Guest Conversion Modal -->
        <Modal :show="showGuestModal" @close="showGuestModal = false" maxWidth="md">
            <div class="p-8 text-center relative overflow-hidden bg-white border-4 border-black rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)]">
                <div class="relative z-10">
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-2xl font-black text-black mb-2">Bạn học đỉnh quá!</h2>
                    <p class="text-black/70 font-bold mb-6">
                        Bạn vừa hoàn thành một phiên ôn tập xuất sắc. Hãy tạo tài khoản miễn phí để hệ thống lưu lại điểm số và nhận ngay <strong class="bg-pastel-orange border-2 border-black px-2 py-1 rounded-full text-black">15 XP</strong> nhé!
                    </p>
                    
                    <div class="flex flex-col gap-3">
                        <Link :href="route('register')" class="w-full py-4 bg-pastel-pink border-4 border-black text-black font-black rounded-2xl shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:-translate-y-1 transition-all">
                            Tạo tài khoản lưu điểm
                        </Link>
                        <button @click="showGuestModal = false" class="w-full py-3 text-black/50 font-black hover:text-black transition-all">
                            Để sau
                        </button>
                    </div>
                </div>
            </div>
        </Modal>

    </div>
</template>

<style scoped>
.perspective {
    perspective: 1200px;
}
.preserve-3d {
    transform-style: preserve-3d;
}
.backface-hidden {
    backface-visibility: hidden;
}
.rotate-y-180 {
    transform: rotateY(180deg);
}
.fade-up-enter-active,
.fade-up-leave-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-up-enter-from,
.fade-up-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
.animate-fade-in-up {
    animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
