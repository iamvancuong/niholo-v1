<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

defineProps({ canLogin: Boolean, canRegister: Boolean });

const eyeTx = ref(0);
const eyeTy = ref(0);
const sunSmiling = ref(false);
const hoveredCard = ref(null);

const handleMouseMove = (e) => {
    const x = (e.clientX / window.innerWidth) * 2 - 1;
    const y = (e.clientY / window.innerHeight) * 2 - 1;
    eyeTx.value = x * 5;
    eyeTy.value = y * 5;
};

onMounted(() => {
    window.addEventListener('mousemove', handleMouseMove);
});

onUnmounted(() => {
    window.removeEventListener('mousemove', handleMouseMove);
});

// Kanji for background pattern
const bgKanjis = [
    { char: '日', top: '10%', left: '5%', size: 'text-8xl', rot: 'rotate-12' },
    { char: '本', top: '25%', left: '85%', size: 'text-9xl', rot: '-rotate-6' },
    { char: '語', top: '65%', left: '10%', size: 'text-7xl', rot: 'rotate-45' },
    { char: '夢', top: '80%', left: '80%', size: 'text-8xl', rot: '-rotate-12' },
    { char: '愛', top: '45%', left: '50%', size: 'text-9xl', rot: 'rotate-6' },
    { char: '学', top: '15%', left: '40%', size: 'text-7xl', rot: '-rotate-12' },
    { char: '習', top: '55%', left: '75%', size: 'text-8xl', rot: 'rotate-12' },
    { char: '笑', top: '90%', left: '30%', size: 'text-9xl', rot: '-rotate-12' }
];

const cards = [
    { 
        id: 'nghe', title: 'Listening', subtitle: 'Luyện Nghe', color: 'bg-pastel-blue', shadow: 'shadow-[6px_6px_0px_#ADE6FF]',
        // Spiky Hair (Crown)
        hair: '<path d="M 30 50 L 35 40 L 45 47 L 55 35 L 65 47 L 75 40 L 70 50" fill="#000" stroke="#000" stroke-width="2" stroke-linejoin="round"/>'
    },
    { 
        id: 'doc', title: 'Reading', subtitle: 'Đọc Hiểu', color: 'bg-pastel-green', shadow: 'shadow-[6px_6px_0px_#B6FABF]',
        // Little Sprout (Mầm cây)
        hair: '<path d="M 50 45 Q 40 30 35 40 Q 40 45 50 45" fill="#B6FABF" stroke="#000" stroke-width="2"/><path d="M 50 45 Q 60 30 65 40 Q 60 45 50 45" fill="#B6FABF" stroke="#000" stroke-width="2"/>'
    },
    { 
        id: 'noi', title: 'Speaking', subtitle: 'Giao Tiếp', color: 'bg-pastel-orange', shadow: 'shadow-[6px_6px_0px_#FAE9B8]',
        // Single Curl (Tóc bờm ngựa / 1 cọng)
        hair: '<path d="M 50 45 C 40 28 60 28 60 38 C 60 43 55 45 50 45 Z" fill="#000" stroke="#000" stroke-width="2"/>'
    },
    { 
        id: 'viet', title: 'Writing', subtitle: 'Viết Câu', color: 'bg-pastel-pink', shadow: 'shadow-[6px_6px_0px_#FFCCC1]',
        // Twin tails / Bow
        hair: '<path d="M 25 55 C 10 40 20 30 30 45 Z" fill="#000" stroke="#000" stroke-width="2"/><path d="M 75 55 C 90 40 80 30 70 45 Z" fill="#000" stroke="#000" stroke-width="2"/>'
    },
    { 
        id: 'tu_vung', title: 'Vocab & Kanji', subtitle: 'Từ Vựng', color: 'bg-indigo-300', shadow: 'shadow-[6px_6px_0px_#a5b4fc]',
        // Samurai Topknot
        hair: '<rect x="40" y="33" width="20" height="12" rx="4" fill="#000" stroke="#000" stroke-width="2"/><path d="M 45 33 L 55 33" stroke="#FFF" stroke-width="2"/>'
    },
];

</script>

<template>
    <div class="min-h-screen font-sans overflow-x-hidden selection:bg-yellow-300 selection:text-black relative" style="background-color: #3d7a4a;">
        <Head title="Niholo – Học Tiếng Nhật Kawaii" />

        <!-- GRID + KANJI BACKGROUND -->
        <div class="fixed inset-0 pointer-events-none select-none z-0 overflow-hidden">
            <!-- Grid lines -->
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 52px 52px;"></div>
            <!-- Floating Kanji -->
            <span class="kanji-float absolute font-black text-white/10 select-none" style="font-size: 11rem; top: 5%; left: 2%; animation-delay: 0s;">日</span>
            <span class="kanji-float absolute font-black text-white/8 select-none"  style="font-size: 14rem; top: 10%; right: 3%; animation-delay: 1.2s;">本</span>
            <span class="kanji-float absolute font-black text-white/10 select-none" style="font-size: 9rem; top: 55%; left: 6%; animation-delay: 0.6s;">語</span>
            <span class="kanji-float absolute font-black text-white/8 select-none"  style="font-size: 12rem; bottom: 8%; right: 8%; animation-delay: 2s;">夢</span>
            <span class="kanji-float absolute font-black text-white/6 select-none"  style="font-size: 16rem; top: 35%; left: 40%; animation-delay: 0.9s;">学</span>
            <span class="kanji-float absolute font-black text-white/10 select-none" style="font-size: 8rem; bottom: 20%; left: 30%; animation-delay: 1.8s;">習</span>
        </div>

        <!-- NAVBAR -->
        <nav class="fixed top-0 inset-x-0 z-50 px-4 md:px-8 py-3 md:py-4 flex items-center justify-between" style="background-color: rgba(30,90,50,0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.12);">
            <div class="flex items-center gap-2">
                <span class="text-lg md:text-xl font-black tracking-tight uppercase px-3 py-1.5 rounded-lg text-white" style="background: rgba(255,255,255,0.18); letter-spacing: 0.08em;">🌸 NIHOLO</span>
            </div>

            <!-- Main Navigation Links -->
            <div class="hidden md:flex items-center gap-8 font-bold text-base text-white/80">
                <a href="#" class="hover:text-yellow-300 transition-colors">Trang chủ</a>
                <Link :href="route('courses.index')" class="hover:text-yellow-300 transition-colors">Lộ trình</Link>
                <a href="#skills" class="hover:text-yellow-300 transition-colors">Phương pháp FSRS</a>
                <Link :href="route('about')" class="hover:text-yellow-300 transition-colors">Co - Founder</Link>
            </div>
            <div class="flex items-center gap-3 font-bold">
                <template v-if="canLogin">
                    <Link :href="route('login')" class="px-4 py-2 text-white/80 hover:text-white transition-colors text-sm">Đăng nhập</Link>
                    <Link v-if="canRegister" :href="route('register')" class="px-5 py-2 rounded-full text-sm font-black text-gray-900 transition-all hover:scale-105 hover:brightness-110" style="background: #aaed5a; box-shadow: 0 4px 15px rgba(170,237,90,0.4);">Bắt đầu</Link>
                </template>
                <template v-else>
                    <Link :href="route('dashboard')" class="px-5 py-2 rounded-full text-sm font-black text-gray-900 transition-all hover:scale-105 hover:brightness-110" style="background: #aaed5a; box-shadow: 0 4px 15px rgba(170,237,90,0.4);">Vào Học</Link>
                </template>
            </div>
        </nav>

        <!-- HERO -->
        <section class="relative min-h-screen flex items-stretch overflow-hidden z-10" @mouseenter="sunSmiling = true" @mouseleave="sunSmiling = false">

            <!-- === LEFT: Sun mascot === -->
            <div class="hidden lg:flex items-end justify-center w-[420px] xl:w-[480px] shrink-0 relative" style="padding-bottom: 0;">
                <div class="relative sun-float" style="width: clamp(340px, 36vw, 500px); aspect-ratio: 1; transform: translate(-18%, 28%);">

                    <!-- Speech bubble (Sun) -->
                    <div class="speech-bubble absolute z-30"
                         style="top: 8%; right: -5%; transform: rotate(4deg);">
                        <div class="bg-white rounded-2xl px-4 py-2.5 font-bold text-gray-800 text-sm leading-snug whitespace-nowrap"
                             style="box-shadow: 3px 3px 0 rgba(0,0,0,0.15);">
                            ☀️ Xin chào! Học tiếng Nhật<br>cùng mình nhé! Ganbatte~
                        </div>
                        <div class="absolute -bottom-3 right-10 w-0 h-0"
                             style="border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 14px solid white;"></div>
                    </div>

                    <!-- Sun SVG: Rotating rays + Kawaii face -->
                    <svg viewBox="0 0 400 400" class="w-full h-full" style="filter: drop-shadow(0 -10px 40px rgba(245,200,66,0.35));">
                        <!-- Rotating spiky rays -->
                        <g class="sun-rays-spin" style="transform-origin: 200px 200px;">
                            <path d="M200 0 L220 60 L260 20 L255 80 L310 60 L285 110 L350 110 L310 155 L380 170 L325 200 L380 230 L310 245 L350 290 L285 290 L310 340 L255 320 L260 380 L220 340 L200 400 L180 340 L140 380 L145 320 L90 340 L115 290 L50 290 L90 245 L20 230 L75 200 L20 170 L90 155 L50 110 L115 110 L90 60 L145 80 L140 20 L180 60 Z"
                                  fill="#e8a820" opacity="0.9"/>
                        </g>
                        <!-- Sun body -->
                        <circle cx="200" cy="200" r="155" fill="#f5c842"/>
                        <circle cx="200" cy="200" r="155" fill="url(#sunBodyGradL)" opacity="0.4"/>
                        <defs>
                            <radialGradient id="sunBodyGradL" cx="35%" cy="30%">
                                <stop offset="0%" stop-color="#fff" stop-opacity="0.5"/>
                                <stop offset="100%" stop-color="#e8a820" stop-opacity="0"/>
                            </radialGradient>
                        </defs>
                        <!-- Left eye -->
                        <circle cx="155" cy="190" r="22" fill="#1a1a1a"/>
                        <circle cx="148" cy="182" r="8" fill="#fff"
                                :style="{ transform: `translate(${eyeTx}px, ${eyeTy}px)`, transformOrigin: '155px 190px' }"/>
                        <!-- Right eye -->
                        <circle cx="245" cy="190" r="22" fill="#1a1a1a"/>
                        <circle cx="238" cy="182" r="8" fill="#fff"
                                :style="{ transform: `translate(${eyeTx}px, ${eyeTy}px)`, transformOrigin: '245px 190px' }"/>
                        <!-- Smile -->
                        <path v-if="!sunSmiling" d="M 162 240 Q 200 265 238 240" stroke="#1a1a1a" stroke-width="10" stroke-linecap="round" fill="none"/>
                        <path v-else d="M 158 238 Q 200 275 242 238" stroke="#1a1a1a" stroke-width="10" stroke-linecap="round" fill="none"/>
                        <!-- Blush marks -->
                        <ellipse cx="125" cy="225" rx="20" ry="10" fill="#e07a40" opacity="0.35"/>
                        <ellipse cx="275" cy="225" rx="20" ry="10" fill="#e07a40" opacity="0.35"/>
                    </svg>
                </div>
            </div>

            <!-- === CENTER: Text content === -->
            <div class="relative z-20 flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 pt-24 pb-16 lg:pt-28 lg:pb-20">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/20 text-white/60 text-xs font-bold mb-6 tracking-widest uppercase"
                     style="background: rgba(255,255,255,0.08);">
                    #NIHOLO_JLPT_PLATFORM
                </div>

                <!-- Headline -->
                <h1 class="font-black text-white mb-3 leading-tight" style="font-size: clamp(2.4rem, 4.5vw, 4rem); text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                    Nền tảng học tiếng Nhật
                </h1>
                <div class="inline-block mb-6 px-6 py-3 rounded-2xl font-black text-gray-900" style="font-size: clamp(2rem, 4vw, 3.4rem); background: #aaed5a; line-height: 1.15; box-shadow: 0 6px 30px rgba(170,237,90,0.5);">
                    Chinh Phục JLPT
                </div>

                <!-- Subtext -->
                <p class="text-white/70 text-base md:text-lg mb-10 max-w-md leading-relaxed font-medium">
                    Đầy đủ từ vựng, bài học theo FSRS, bài tập đa dạng giúp bạn chinh phục JLPT từ N5 đến N1 mỗi ngày.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                    <Link :href="route('courses.index')"
                          class="w-full sm:w-auto text-center px-7 py-3.5 rounded-full font-black text-gray-900 text-base transition-all hover:scale-105 hover:brightness-110"
                          style="background: #aaed5a; box-shadow: 0 4px 24px rgba(170,237,90,0.45);">
                        Học Ngay →
                    </Link>
                    <a href="#skills"
                       class="w-full sm:w-auto text-center px-7 py-3.5 rounded-full font-black text-white text-base border border-white/25 hover:border-white/60 hover:bg-white/15 transition-all"
                       style="background: rgba(255,255,255,0.08);">
                        Khám phá lộ trình
                    </a>
                </div>

                <!-- Stats strip -->
                <div class="flex gap-8 mt-12 justify-center">
                    <div>
                        <div class="text-white font-black text-2xl">2,000+</div>
                        <div class="text-white/50 text-xs font-bold uppercase tracking-wider">Từ Vựng</div>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <div class="text-white font-black text-2xl">N5 → N1</div>
                        <div class="text-white/50 text-xs font-bold uppercase tracking-wider">Lộ Trình</div>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <div class="text-white font-black text-2xl">FSRS</div>
                        <div class="text-white/50 text-xs font-bold uppercase tracking-wider">Thuật Toán</div>
                    </div>
                </div>
            </div>

            <!-- === RIGHT: Mount Fuji mascot === -->
            <div class="hidden lg:flex items-end justify-center w-[420px] xl:w-[480px] shrink-0 relative">
                <div class="relative fuji-float" style="width: clamp(340px, 36vw, 500px); aspect-ratio: 1; transform: translate(18%, 28%);">

                    <!-- Speech bubble (Fuji) -->
                    <div class="speech-bubble-fuji absolute z-30"
                         style="top: 8%; left: -5%; transform: rotate(-4deg);">
                        <div class="bg-white rounded-2xl px-4 py-2.5 font-bold text-gray-800 text-sm leading-snug whitespace-nowrap"
                             style="box-shadow: 3px 3px 0 rgba(0,0,0,0.15);">
                            🗻 富士山へようこそ！<br>Lên đến đỉnh JLPT N1<br>cùng Niholo nhé! 🌸
                        </div>
                        <div class="absolute -bottom-3 left-10 w-0 h-0"
                             style="border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 14px solid white;"></div>
                    </div>

                    <!-- Mount Fuji SVG: Kawaii style -->
                    <svg viewBox="0 0 400 400" class="w-full h-full" style="filter: drop-shadow(0 -10px 40px rgba(100,160,240,0.35));">
                        <defs>
                            <!-- Sky gradient behind mountain -->
                            <radialGradient id="fujiSkyGrad" cx="50%" cy="60%" r="65%">
                                <stop offset="0%" stop-color="#b8e0ff" stop-opacity="0.35"/>
                                <stop offset="100%" stop-color="#3d7a4a" stop-opacity="0"/>
                            </radialGradient>
                            <!-- Mountain body gradient -->
                            <linearGradient id="fujiBluGrad" x1="30%" y1="0%" x2="70%" y2="100%">
                                <stop offset="0%" stop-color="#6a9fd8"/>
                                <stop offset="60%" stop-color="#4a7fc1"/>
                                <stop offset="100%" stop-color="#2d5fa0"/>
                            </linearGradient>
                            <!-- Snow cap gradient -->
                            <linearGradient id="fujiSnowGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ffffff"/>
                                <stop offset="70%" stop-color="#dceeff"/>
                                <stop offset="100%" stop-color="#c5dff8"/>
                            </linearGradient>
                            <!-- Glow circle behind -->
                            <radialGradient id="fujiGlowGrad" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#90c8f0" stop-opacity="0.5"/>
                                <stop offset="100%" stop-color="#4a7fc1" stop-opacity="0"/>
                            </radialGradient>
                        </defs>

                        <!-- Glow circle (equivalent to sun's glow) -->
                        <circle cx="200" cy="230" r="155" fill="url(#fujiGlowGrad)"/>

                        <!-- Background sky tint -->
                        <ellipse cx="200" cy="260" rx="175" ry="140" fill="url(#fujiSkyGrad)"/>

                        <!-- Rotating sparkle ring (equivalent to sun's spinning rays) -->
                        <g class="fuji-sparkles-spin" style="transform-origin: 200px 200px;">
                            <!-- 8 sparkle stars around the mountain -->
                            <g fill="#a8d8f0" opacity="0.85">
                                <polygon points="200,30 204,44 218,44 207,52 211,66 200,58 189,66 193,52 182,44 196,44" transform="rotate(0,200,200)"/>
                                <polygon points="200,30 202,38 210,38 204,43 206,51 200,47 194,51 196,43 190,38 198,38" transform="rotate(45,200,200)" opacity="0.6"/>
                                <polygon points="200,30 204,44 218,44 207,52 211,66 200,58 189,66 193,52 182,44 196,44" transform="rotate(90,200,200)"/>
                                <polygon points="200,30 202,38 210,38 204,43 206,51 200,47 194,51 196,43 190,38 198,38" transform="rotate(135,200,200)" opacity="0.6"/>
                                <polygon points="200,30 204,44 218,44 207,52 211,66 200,58 189,66 193,52 182,44 196,44" transform="rotate(180,200,200)"/>
                                <polygon points="200,30 202,38 210,38 204,43 206,51 200,47 194,51 196,43 190,38 198,38" transform="rotate(225,200,200)" opacity="0.6"/>
                                <polygon points="200,30 204,44 218,44 207,52 211,66 200,58 189,66 193,52 182,44 196,44" transform="rotate(270,200,200)"/>
                                <polygon points="200,30 202,38 210,38 204,43 206,51 200,47 194,51 196,43 190,38 198,38" transform="rotate(315,200,200)" opacity="0.6"/>
                            </g>
                        </g>

                        <!-- Mountain body (main) -->
                        <path d="M200 60 L340 320 L60 320 Z" fill="url(#fujiBluGrad)"/>
                        <!-- Mountain left shadow -->
                        <path d="M200 60 L130 320 L60 320 Z" fill="#2d5fa0" opacity="0.35"/>
                        <!-- Mountain right highlight -->
                        <path d="M200 60 L260 320 L340 320 Z" fill="#90b8e0" opacity="0.2"/>

                        <!-- Snow cap -->
                        <path d="M200 60 L240 145 Q220 135 200 138 Q180 135 160 145 Z" fill="url(#fujiSnowGrad)"/>
                        <!-- Snow drips left -->
                        <path d="M160 145 Q148 155 138 165 Q145 158 155 160 Q162 152 168 155 Q164 148 160 145Z" fill="white" opacity="0.9"/>
                        <!-- Snow drips right -->
                        <path d="M240 145 Q252 155 262 165 Q255 158 245 160 Q238 152 232 155 Q236 148 240 145Z" fill="white" opacity="0.9"/>
                        <!-- Snow highlight shimmer -->
                        <ellipse cx="200" cy="100" rx="22" ry="10" fill="white" opacity="0.45"/>

                        <!-- Kawaii Face on mountain -->
                        <!-- Left eye -->
                        <circle cx="175" cy="215" r="18" fill="#1a1a1a"/>
                        <circle cx="169" cy="208" r="7" fill="#fff"
                                :style="{ transform: `translate(${eyeTx * 0.6}px, ${eyeTy * 0.6}px)`, transformOrigin: '175px 215px' }"/>
                        <!-- Right eye -->
                        <circle cx="225" cy="215" r="18" fill="#1a1a1a"/>
                        <circle cx="219" cy="208" r="7" fill="#fff"
                                :style="{ transform: `translate(${eyeTx * 0.6}px, ${eyeTy * 0.6}px)`, transformOrigin: '225px 215px' }"/>
                        <!-- Smile (always happy Fuji) -->
                        <path d="M 183 252 Q 200 268 217 252" stroke="#1a1a1a" stroke-width="9" stroke-linecap="round" fill="none"/>
                        <!-- Blush marks -->
                        <ellipse cx="148" cy="240" rx="16" ry="9" fill="#7aaed6" opacity="0.45"/>
                        <ellipse cx="252" cy="240" rx="16" ry="9" fill="#7aaed6" opacity="0.45"/>

                        <!-- Floating cloud left -->
                        <g class="cloud-drift-l" style="transform-origin: 90px 280px;">
                            <ellipse cx="90" cy="285" rx="32" ry="16" fill="white" opacity="0.85"/>
                            <ellipse cx="75" cy="290" rx="18" ry="13" fill="white" opacity="0.85"/>
                            <ellipse cx="108" cy="290" rx="22" ry="12" fill="white" opacity="0.85"/>
                        </g>
                        <!-- Floating cloud right -->
                        <g class="cloud-drift-r" style="transform-origin: 315px 260px;">
                            <ellipse cx="315" cy="265" rx="28" ry="14" fill="white" opacity="0.8"/>
                            <ellipse cx="300" cy="270" rx="16" ry="11" fill="white" opacity="0.8"/>
                            <ellipse cx="332" cy="270" rx="18" ry="11" fill="white" opacity="0.8"/>
                        </g>

                        <!-- Ground / Base -->
                        <path d="M30 320 Q200 305 370 320 L400 400 L0 400 Z" fill="#2a6038" opacity="0.6"/>
                        <!-- Cherry blossom tree hints -->
                        <circle cx="75" cy="310" r="14" fill="#ffb7c5" opacity="0.75"/>
                        <rect x="73" y="318" width="4" height="12" fill="#6b3d20" opacity="0.6"/>
                        <circle cx="325" cy="308" r="12" fill="#ffb7c5" opacity="0.75"/>
                        <rect x="323" y="316" width="4" height="12" fill="#6b3d20" opacity="0.6"/>

                    </svg>
                </div>
            </div>

        </section>


        <!-- INTRODUCTION SECTION -->
        <section class="py-24 px-6 bg-white border-t-4 border-black relative z-10 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black mb-4 uppercase" style="text-shadow: 3px 3px 0px #aaed5a;">Học Tiếng Nhật Không Còn Nhàm Chán!</h2>
                    <p class="text-xl font-bold text-gray-700 max-w-3xl mx-auto">Niholo biến việc học ngoại ngữ từ một "nghĩa vụ" thành một "trò chơi". Tận dụng sức mạnh của thuật toán FSRS giúp bạn ghi nhớ từ vựng mãi mãi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                    <!-- Card 1: Streak (Fire Mascot) -->
                    <div class="bg-white border-4 border-black p-6 md:p-8 rounded-3xl shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] md:hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all group relative mt-10 lg:mt-0">
                        <div class="absolute -top-14 -right-6 w-28 h-28 transition-transform duration-300 group-hover:-translate-y-4 group-hover:rotate-6 z-10 pointer-events-none">
                            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[4px_4px_0px_rgba(0,0,0,0.15)]">
                                <!-- Fire body -->
                                <path d="M 50 10 Q 75 40 80 60 A 30 30 0 0 1 20 60 Q 25 40 50 10 Z" fill="#ff6b00" stroke="#000" stroke-width="4" stroke-linejoin="round" />
                                <!-- Inner fire -->
                                <path d="M 50 30 Q 65 50 70 65 A 20 20 0 0 1 30 65 Q 35 50 50 30 Z" fill="#ffc800" stroke="#000" stroke-width="3" stroke-linejoin="round" />
                                <!-- Face -->
                                <circle cx="38" cy="65" r="4" fill="#000" />
                                <circle cx="62" cy="65" r="4" fill="#000" />
                                <path d="M 45 72 Q 50 78 55 72" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <!-- Sparkles -->
                                <path d="M 20 30 L 25 35 M 25 30 L 20 35" stroke="#ffc800" stroke-width="3" stroke-linecap="round" />
                                <path d="M 80 25 L 85 30 M 85 25 L 80 30" stroke="#ffc800" stroke-width="3" stroke-linecap="round" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-4 uppercase text-gray-900 mt-2">1. Streak</h3>
                        <p class="font-bold text-gray-700 text-lg">Giữ lửa đam mê học tập mỗi ngày với hệ thống Streak tương tác, nhắc nhở bạn không bỏ cuộc.</p>
                    </div>

                    <!-- Card 2: FSRS (Lightbulb Mascot) -->
                    <div class="bg-pastel-pink border-4 border-black p-6 md:p-8 rounded-3xl shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] md:hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all group relative mt-10 lg:mt-0 lg:translate-y-6">
                        <div class="absolute -top-14 -right-6 w-28 h-28 transition-transform duration-300 group-hover:-translate-y-4 group-hover:-rotate-6 z-10 pointer-events-none">
                            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[4px_4px_0px_rgba(0,0,0,0.15)]">
                                <!-- Glow/Rays -->
                                <path d="M 50 5 L 50 12 M 15 25 L 22 30 M 85 25 L 78 30 M 10 50 L 17 50 M 90 50 L 83 50" stroke="#ffc800" stroke-width="4" stroke-linecap="round" />
                                <!-- Bulb Glass -->
                                <path d="M 30 40 C 30 15 70 15 70 40 C 70 55 60 65 60 72 L 40 72 C 40 65 30 55 30 40 Z" fill="#fffbe6" stroke="#000" stroke-width="4" stroke-linejoin="round" />
                                <!-- Base -->
                                <rect x="42" y="72" width="16" height="15" rx="3" fill="#a0aec0" stroke="#000" stroke-width="4" />
                                <line x1="42" y1="77" x2="58" y2="77" stroke="#000" stroke-width="4" />
                                <!-- Face -->
                                <circle cx="40" cy="45" r="4" fill="#000" />
                                <circle cx="60" cy="45" r="4" fill="#000" />
                                <path d="M 46 52 Q 50 58 54 52" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <ellipse cx="32" cy="50" rx="4" ry="2" fill="#ff9999" opacity="0.8" />
                                <ellipse cx="68" cy="50" rx="4" ry="2" fill="#ff9999" opacity="0.8" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-4 uppercase text-gray-900 mt-2">2. Thuật toán FSRS</h3>
                        <p class="font-bold text-gray-800 text-lg">Tính toán chính xác thời điểm vàng để ôn tập, tối ưu hóa trí nhớ dài hạn và tiết kiệm thời gian.</p>
                    </div>

                    <!-- Card 3: JLPT (Daruma Mascot) -->
                    <div class="bg-pastel-green border-4 border-black p-6 md:p-8 rounded-3xl shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] md:hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all group relative mt-10 lg:mt-0">
                        <div class="absolute -top-14 -right-6 w-28 h-28 transition-transform duration-300 group-hover:-translate-y-4 group-hover:rotate-6 z-10 pointer-events-none">
                            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[4px_4px_0px_rgba(0,0,0,0.15)]">
                                <!-- Daruma Body -->
                                <path d="M 20 50 C 20 10 80 10 80 50 C 85 90 15 90 20 50 Z" fill="#e53e3e" stroke="#000" stroke-width="4" />
                                <!-- Face Area -->
                                <ellipse cx="50" cy="45" rx="22" ry="18" fill="#ffedd5" stroke="#000" stroke-width="3" />
                                <!-- Eyes -->
                                <circle cx="40" cy="43" r="5" fill="#fff" stroke="#000" stroke-width="2" />
                                <circle cx="40" cy="43" r="2" fill="#000" />
                                <circle cx="60" cy="43" r="5" fill="#fff" stroke="#000" stroke-width="2" />
                                <circle cx="60" cy="43" r="2" fill="#000" /> 
                                <!-- Eyebrows -->
                                <path d="M 33 34 Q 40 32 45 38" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <path d="M 67 34 Q 60 32 55 38" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <!-- Mustache -->
                                <path d="M 42 52 Q 50 48 58 52" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <!-- Gold pattern -->
                                <path d="M 40 75 Q 50 85 60 75" stroke="#ecc94b" stroke-width="4" stroke-linecap="round" fill="none" />
                                <path d="M 45 82 Q 50 88 55 82" stroke="#ecc94b" stroke-width="4" stroke-linecap="round" fill="none" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-4 uppercase text-gray-900 mt-2">3. Sát đề JLPT</h3>
                        <p class="font-bold text-gray-800 text-lg">Cấu trúc bài học và từ vựng bám sát 100% đề thi JLPT thực tế từ N5 đến N1.</p>
                    </div>

                    <!-- Card 4: UI Kawaii (Onigiri Mascot) -->
                    <div class="bg-pastel-yellow border-4 border-black p-6 md:p-8 rounded-3xl shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] md:hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all group relative mt-10 lg:mt-0 lg:translate-y-6">
                        <div class="absolute -top-14 -right-6 w-28 h-28 transition-transform duration-300 group-hover:-translate-y-4 group-hover:-rotate-6 z-10 pointer-events-none">
                            <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[4px_4px_0px_rgba(0,0,0,0.15)]">
                                <!-- Onigiri Body -->
                                <path d="M 50 15 Q 75 15 85 65 Q 90 85 50 85 Q 10 85 15 65 Q 25 15 50 15 Z" fill="#fff" stroke="#000" stroke-width="4" stroke-linejoin="round" />
                                <!-- Seaweed -->
                                <rect x="35" y="65" width="30" height="20" fill="#2d3748" stroke="#000" stroke-width="3" />
                                <!-- Face -->
                                <circle cx="38" cy="45" r="4" fill="#000" />
                                <circle cx="62" cy="45" r="4" fill="#000" />
                                <path d="M 46 52 Q 50 58 54 52" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <ellipse cx="30" cy="50" rx="4" ry="2" fill="#ff9999" opacity="0.8" />
                                <ellipse cx="70" cy="50" rx="4" ry="2" fill="#ff9999" opacity="0.8" />
                                <!-- Little rice grain -->
                                <ellipse cx="25" cy="40" rx="3" ry="5" fill="#fff" stroke="#000" stroke-width="2" transform="rotate(-30 25 40)" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-4 uppercase text-gray-900 mt-2">4. UI Kawaii</h3>
                        <p class="font-bold text-gray-800 text-lg">Thiết kế chuẩn Neo-Brutalism kết hợp Kawaii giúp não bộ thư giãn và dễ tiếp thu hơn.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SKILL CARDS SECTION -->
        <section id="skills" class="py-24 px-6 bg-white border-y-4 border-black relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black mb-4 uppercase" style="text-shadow: 3px 3px 0px #ADE6FF;">Phát Triển Toàn Diện</h2>
                    <p class="text-xl font-bold">5 kỹ năng cần thiết để làm chủ tiếng Nhật</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    <div v-for="card in cards" :key="card.id" 
                        class="relative rounded-3xl border-4 border-black p-6 h-80 flex flex-col justify-between overflow-hidden cursor-pointer transition-all duration-300 hover:-translate-y-3 bg-opacity-90"
                        :class="[card.color, card.shadow]"
                        @mouseenter="hoveredCard = card.id" 
                        @mouseleave="hoveredCard = null"
                    >
                        <!-- Card Header -->
                        <div class="z-10">
                            <div class="w-12 h-12 bg-white border-2 border-black rounded-xl mb-4 flex items-center justify-center font-black text-2xl shadow-[2px_2px_0px_#000]">
                                {{ card.title.charAt(0) }}
                            </div>
                            <h3 class="text-2xl font-black mb-1">{{ card.title }}</h3>
                            <p class="font-bold text-sm">{{ card.subtitle }}</p>
                        </div>
                        
                        <!-- 100+ Đề badge -->
                        <div class="z-10 absolute top-2 right-2 px-4 py-1 bg-white border-2 border-black rounded-full font-black text-sm shadow-[2px_2px_0px_#000]">
                            100+ Bài
                        </div>

                        <!-- Mochi Mascot Peeking from bottom -->
                        <div class="absolute left-1/2 -translate-x-1/2 -bottom-8 w-40 h-36 transition-transform duration-300 pointer-events-none"
                            :class="hoveredCard === card.id ? '-translate-y-8' : ''">
                            <svg viewBox="0 0 100 90" class="w-full h-full drop-shadow-md">
                                <!-- Dynamic Hair Feature -->
                                <g v-html="card.hair" class="transition-transform duration-300" :class="hoveredCard === card.id ? '-translate-y-1' : ''"></g>
                                
                                <!-- Mochi Body -->
                                <path d="M 10 90 C 10 30 90 30 90 90" fill="#fff" stroke="#000" stroke-width="4" stroke-linejoin="round"/>
                                
                                <!-- Blushes -->
                                <ellipse cx="30" cy="65" rx="7" ry="4" fill="#ff9999" class="opacity-70" />
                                <ellipse cx="70" cy="65" rx="7" ry="4" fill="#ff9999" class="opacity-70" />
                                
                                <!-- Eyes -->
                                <g>
                                    <circle cx="35" cy="55" r="7" fill="#000" />
                                    <circle cx="37" cy="53" r="2" fill="#fff" :style="{ transform: `translate(${eyeTx}px, ${eyeTy}px)` }" />
                                    
                                    <circle cx="65" cy="55" r="7" fill="#000" />
                                    <circle cx="67" cy="53" r="2" fill="#fff" :style="{ transform: `translate(${eyeTx}px, ${eyeTy}px)` }" />
                                </g>
                                
                                <!-- Mouth -->
                                <path v-if="hoveredCard !== card.id" d="M 45 65 Q 50 68 55 65" stroke="#000" stroke-width="3" stroke-linecap="round" fill="none" />
                                <path v-else d="M 43 65 Q 50 78 57 65 Z" stroke="#000" stroke-width="3" stroke-linecap="round" fill="#FFCCC1" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROADMAP SECTION -->
        <section class="py-32 px-6 overflow-hidden relative z-10 bg-[#f8f9fa]">
            <div class="max-w-5xl mx-auto text-center relative">
                <h2 class="text-5xl font-black mb-6 uppercase" style="text-shadow: 3px 3px 0px #B6FABF;">Lộ Trình Học Rõ Ràng</h2>
                <p class="text-xl font-bold text-gray-700 max-w-2xl mx-auto mb-16">Chinh phục tiếng Nhật từ con số 0 đến cấp độ cao nhất một cách bài bản và khoa học.</p>
                
                <div class="relative flex flex-col items-center gap-12">
                    <!-- The Winding Path Line (behind) -->
                    <div class="absolute top-0 bottom-0 w-4 bg-black rounded-full z-0 opacity-10 left-1/2 -translate-x-1/2"></div>

                    <!-- Steps -->
                    <div v-for="(step, index) in [
                        { level: 'N5', title: 'Căn Bản', desc: 'Làm quen với Hiragana, Katakana và các mẫu câu cơ bản nhất.', color: 'bg-pastel-pink', translate: 'md:-translate-x-1/2 md:pr-12', align: 'md:text-right', flex: 'md:flex-row-reverse', rot: '-rotate-2' },
                        { level: 'N4', title: 'Sơ Trung', desc: 'Giao tiếp hàng ngày, đọc hiểu các đoạn văn ngắn.', color: 'bg-pastel-orange', translate: 'md:translate-x-1/2 md:pl-12', align: 'md:text-left', flex: 'md:flex-row', rot: 'rotate-3' },
                        { level: 'N3', title: 'Trung Cấp', desc: 'Đọc hiểu báo chí cơ bản, giao tiếp tự nhiên với người bản xứ.', color: 'bg-pastel-yellow', translate: 'md:-translate-x-1/2 md:pr-12', align: 'md:text-right', flex: 'md:flex-row-reverse', rot: '-rotate-1' },
                        { level: 'N2', title: 'Nâng Cao', desc: 'Thành thạo trong môi trường công sở, đọc tài liệu chuyên ngành.', color: 'bg-pastel-green', translate: 'md:translate-x-1/2 md:pl-12', align: 'md:text-left', flex: 'md:flex-row', rot: 'rotate-2' },
                        { level: 'N1', title: 'Thành Thạo', desc: 'Sử dụng tiếng Nhật như người bản xứ, thấu hiểu văn hóa.', color: 'bg-pastel-blue', translate: 'md:-translate-x-1/2 md:pr-12', align: 'md:text-right', flex: 'md:flex-row-reverse', rot: '-rotate-3' }
                    ]" :key="step.level" 
                    class="relative z-10 w-full flex flex-col md:flex-row items-center justify-center gap-6" :class="[step.flex]">
                        
                        <!-- Level Node -->
                        <div class="w-24 h-24 shrink-0 rounded-full border-4 border-black flex items-center justify-center font-black text-4xl shadow-[6px_6px_0px_rgba(0,0,0,1)] z-20 hover:scale-110 transition-transform" :class="step.color">
                            {{ step.level }}
                        </div>
                        
                        <!-- Content Card -->
                        <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] md:hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all max-w-sm w-full relative group" :class="step.rot">
                            <h4 class="font-black text-2xl uppercase mb-2">{{ step.title }}</h4>
                            <p class="font-bold text-gray-700">{{ step.desc }}</p>
                        </div>

                    </div>
                </div>
                
                <div class="mt-24">
                     <Link :href="route('courses.index')" class="inline-flex items-center justify-center w-full md:w-auto gap-3 px-8 md:px-12 py-4 md:py-6 bg-black text-white rounded-full font-black text-xl md:text-2xl shadow-[4px_4px_0px_#aaed5a] md:shadow-[8px_8px_0px_#aaed5a] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] md:hover:translate-x-[8px] md:hover:translate-y-[8px] transition-all">
                        Tạo Tài Khoản Ngay
                    </Link>
                </div>
            </div>
        </section>

        <!-- TESTIMONIAL / CTA SECTION -->
        <section class="py-24 px-6 border-t-4 border-black relative z-10 bg-pastel-pink overflow-hidden">
            <div class="max-w-5xl mx-auto relative z-20 text-center">
                <div class="text-7xl mb-6">💬</div>
                <h2 class="text-4xl font-black mb-10 leading-snug">"Nhờ thuật toán FSRS của Niholo, mình đã đỗ N3 chỉ sau 6 tháng mà không hề thấy áp lực nhồi nhét."</h2>
                <div class="flex items-center justify-center gap-4">
                    <div class="w-16 h-16 bg-white border-4 border-black rounded-full overflow-hidden shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="text-left">
                        <p class="font-black text-xl">Hải Đăng</p>
                        <p class="font-bold text-gray-800">Học viên JLPT N3</p>
                    </div>
                </div>
            </div>
            
            <!-- Floating Decorative Elements -->
            <div class="absolute top-10 left-10 text-6xl opacity-50 rotate-12">⭐</div>
            <div class="absolute bottom-10 right-20 text-6xl opacity-50 -rotate-12">✨</div>
            <div class="absolute top-20 right-10 text-5xl opacity-50 rotate-45">🎌</div>
        </section>

        <!-- FOOTER SECTION -->
        <footer class="py-16 px-10 border-t-4 border-black bg-white relative z-10">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2 text-center md:text-left mb-10 md:mb-0">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                        <span class="font-black text-4xl md:text-5xl uppercase bg-pastel-blue px-6 py-2 border-4 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[6px_6px_0px_rgba(0,0,0,1)] rotate-[-2deg]">Niholo</span>
                    </div>
                    <p class="font-bold text-xl text-gray-800 mb-6 max-w-sm mx-auto md:mx-0">Học tiếng Nhật phong cách Kawaii. Chinh phục JLPT chưa bao giờ dễ dàng và thú vị đến thế.</p>
                    <div class="flex justify-center md:justify-start gap-4">
                        <a href="#" class="w-12 h-12 bg-pastel-pink border-4 border-black rounded-full flex items-center justify-center font-black text-xl shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">f</a>
                        <a href="#" class="w-12 h-12 bg-pastel-yellow border-4 border-black rounded-full flex items-center justify-center font-black text-xl shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">X</a>
                        <a href="#" class="w-12 h-12 bg-pastel-green border-4 border-black rounded-full flex items-center justify-center font-black text-xl shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">in</a>
                    </div>
                </div>
                
                <div class="text-center md:text-left">
                    <h4 class="font-black text-2xl mb-6 uppercase border-b-4 border-black inline-block pb-2">Khám Phá</h4>
                    <ul class="space-y-4 font-bold text-lg">
                        <li><a href="#" class="hover:text-pastel-orange hover:translate-x-2 inline-block transition-transform">Trang chủ</a></li>
                        <li><a href="#skills" class="hover:text-pastel-orange hover:translate-x-2 inline-block transition-transform">Kỹ năng</a></li>
                        <li><Link :href="route('courses.index')" class="hover:text-pastel-orange hover:translate-x-2 inline-block transition-transform">Khóa học</Link></li>
                        <li><a href="#" class="hover:text-pastel-orange hover:translate-x-2 inline-block transition-transform">Về chúng tôi</a></li>
                    </ul>
                </div>
                
                <div class="text-center md:text-left">
                    <h4 class="font-black text-2xl mb-6 uppercase border-b-4 border-black inline-block pb-2">Liên Hệ</h4>
                    <ul class="space-y-4 font-bold text-lg">
                        <li>📧 vancuongit2021@gmail.com</li>
                        <li>📞 +84 886160515</li>
                        <li>📍 Hà Nội, Việt Nam</li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t-4 border-black text-center font-bold text-gray-700">
                <p>© 2026 Văn Cường (iamvancuong) & Niholo JLPT Platform.</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Kanji floating animation */
.kanji-float {
    animation: kanjiDrift 8s ease-in-out infinite;
}
.kanji-float:nth-child(2) { animation-duration: 10s; }
.kanji-float:nth-child(3) { animation-duration: 7s; }
.kanji-float:nth-child(4) { animation-duration: 12s; }
.kanji-float:nth-child(5) { animation-duration: 9s; }
.kanji-float:nth-child(6) { animation-duration: 11s; }
@keyframes kanjiDrift {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33%       { transform: translateY(-14px) rotate(2deg); }
    66%       { transform: translateY(8px) rotate(-1.5deg); }
}

/* Sun float bobbing */
.sun-float {
    animation: sunFloat 4s ease-in-out infinite;
}
@keyframes sunFloat {
    0%, 100% { transform: translate(-18%, 28%) translateY(0px); }
    50%       { transform: translate(-18%, 28%) translateY(-18px); }
}

/* Rotating rays */
.sun-rays-spin {
    animation: raysSpin 20s linear infinite;
}
@keyframes raysSpin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

/* Speech bubble gentle sway (Sun) */
.speech-bubble {
    animation: bubbleSway 3s ease-in-out infinite;
}
@keyframes bubbleSway {
    0%, 100% { transform: rotate(4deg) translateY(0px); }
    50%       { transform: rotate(2deg) translateY(-6px); }
}

/* === Mount Fuji animations === */

/* Fuji float – gentler, slower bob */
.fuji-float {
    animation: fujiFloat 5s ease-in-out infinite;
}
@keyframes fujiFloat {
    0%, 100% { transform: translate(18%, 28%) translateY(0px); }
    50%       { transform: translate(18%, 28%) translateY(-14px); }
}

/* Fuji sparkles – slow reverse spin */
.fuji-sparkles-spin {
    animation: fujSparkSpin 30s linear infinite reverse;
}
@keyframes fujSparkSpin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

/* Speech bubble (Fuji) gentle sway */
.speech-bubble-fuji {
    animation: bubbleSwayFuji 3.5s ease-in-out infinite;
}
@keyframes bubbleSwayFuji {
    0%, 100% { transform: rotate(-4deg) translateY(0px); }
    50%       { transform: rotate(-2deg) translateY(-5px); }
}

/* Clouds drifting */
.cloud-drift-l {
    animation: cloudDriftL 6s ease-in-out infinite;
}
@keyframes cloudDriftL {
    0%, 100% { transform: translateX(0px); }
    50%       { transform: translateX(-8px); }
}
.cloud-drift-r {
    animation: cloudDriftR 7s ease-in-out infinite;
}
@keyframes cloudDriftR {
    0%, 100% { transform: translateX(0px); }
    50%       { transform: translateX(8px); }
}
</style>
