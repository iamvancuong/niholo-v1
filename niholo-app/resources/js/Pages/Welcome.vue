<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({ canLogin: Boolean, canRegister: Boolean });

const isDark = ref(false);
const heroVisible = ref(false);
const activeFeature = ref(0);

const toggleTheme = () => {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle('dark', isDark.value);
    localStorage.setItem('niholo-theme', isDark.value ? 'dark' : 'light');
};

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
    setTimeout(() => heroVisible.value = true, 80);
    setInterval(() => activeFeature.value = (activeFeature.value + 1) % 4, 3000);
    const obs = new IntersectionObserver(entries => entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('in-view');
    }), { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
});
</script>

<template>
    <Head title="Niholo – Học Tiếng Nhật JLPT" />
    <div class="min-h-screen bg-white dark:bg-gray-950 text-gray-900 dark:text-white font-sans transition-colors duration-300">

        <!-- NAVBAR -->
        <nav class="fixed top-0 inset-x-0 z-50 px-6 py-4 flex items-center justify-between backdrop-blur-xl bg-white/80 dark:bg-gray-950/80 border-b border-gray-200/60 dark:border-white/5">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌸</span>
                <span class="text-xl font-black tracking-tight bg-gradient-to-r from-indigo-600 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent">Niholo</span>
            </div>
            <div class="flex items-center gap-3">
                <button @click="toggleTheme" class="p-2 rounded-xl bg-gray-100 dark:bg-white/8 hover:bg-gray-200 dark:hover:bg-white/15 transition text-gray-600 dark:text-gray-300">
                    <svg v-if="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <template v-if="canLogin">
                    <Link :href="route('login')" class="px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Đăng nhập</Link>
                    <Link v-if="canRegister" :href="route('register')" class="px-4 py-2 text-sm bg-gradient-to-r from-indigo-500 to-pink-500 rounded-xl font-bold text-white hover:opacity-90 hover:-translate-y-0.5 transition-all shadow-lg shadow-indigo-500/20">Bắt đầu miễn phí</Link>
                </template>
            </div>
        </nav>

        <!-- HERO -->
        <section class="relative min-h-screen flex flex-col items-center justify-center px-6 pt-24 pb-16 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-400/10 dark:bg-indigo-600/20 rounded-full blur-3xl animate-blob pointer-events-none"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-pink-400/10 dark:bg-pink-600/15 rounded-full blur-3xl animate-blob pointer-events-none" style="animation-delay:1.5s"></div>
            <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
                <span v-for="(k,i) in ['日','本','語','学','習','N5']" :key="i" class="absolute text-gray-100 dark:text-white/5 font-black text-5xl animate-float" :style="`top:${[12,25,65,70,35,45][i]}%;left:${[5,88,8,80,20,75][i]}%;font-size:${[4,3.5,5,3,3,4][i]}rem;animation-delay:${i*0.4}s`">{{ k }}</span>
            </div>
            <div class="relative text-center max-w-4xl mx-auto transition-all duration-700" :class="heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/30 rounded-full text-indigo-600 dark:text-indigo-300 text-sm font-semibold mb-8">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    Nền tảng học JLPT thông minh · Thuật toán FSRS
                </div>
                <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6">
                    Học Tiếng Nhật<br>
                    <span class="bg-gradient-to-r from-indigo-500 via-violet-500 to-pink-500 bg-clip-text text-transparent">Đúng Cách.</span>
                </h1>
                <p class="text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Flashcard FSRS · Ghép câu · Luyện nghe · Lộ trình N5–N1 · Streak giữ động lực mỗi ngày.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link :href="route('courses.index')" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-2xl font-bold text-lg text-white shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">Bắt đầu học ngay →</Link>
                    <a href="#features" class="px-8 py-4 bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl font-bold text-lg text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">Tìm hiểu thêm</a>
                </div>
                <div class="flex flex-wrap gap-10 justify-center mt-16">
                    <div v-for="s in [['5','Cấp độ JLPT'],['20K+','Từ vựng'],['FSRS','Thuật toán'],['3','Dạng bài tập'],['🔥','Streak hàng ngày']]" :key="s[0]" class="text-center">
                        <p class="text-3xl font-black text-gray-900 dark:text-white">{{ s[0] }}</p>
                        <p class="text-sm text-gray-400 mt-1">{{ s[1] }}</p>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 animate-bounce opacity-30">
                <span class="text-xs text-gray-400 font-medium">Cuộn xuống</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="features" class="py-24 px-6 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <p class="text-sm font-bold text-indigo-500 uppercase tracking-widest mb-3">Tính Năng</p>
                    <h2 class="text-4xl md:text-5xl font-black mb-4">Mọi Thứ Bạn Cần <span class="bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Để Thành Công</span></h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg max-w-xl mx-auto">Thiết kế dành riêng cho người học tiếng Nhật, tích hợp phương pháp khoa học nhất.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-5">
                    <div v-for="(f,i) in [
                        {icon:'🗂️',title:'Flashcard FSRS',desc:'Thuật toán spaced repetition thông minh. Hiển thị từ đúng lúc sắp quên – ghi nhớ cực sâu, cực lâu.',color:'indigo'},
                        {icon:'🧩',title:'Ghép Câu',desc:'Kéo thả từng khối từ để tạo câu hoàn chỉnh. Luyện ngữ pháp qua thực hành thực tế, không lý thuyết suông.',color:'pink'},
                        {icon:'✍️',title:'Điền Chữ',desc:'Nghe hoặc đọc câu tiếng Việt rồi tự nhập câu tiếng Nhật. Không cần gõ dấu câu, chỉ cần nội dung đúng.',color:'violet'},
                        {icon:'🎧',title:'Nghe & Ghép',desc:'Nghe audio câu ví dụ rồi ghép lại bằng cách sắp xếp từ. Luyện phản xạ nghe hiểu cực hiệu quả.',color:'amber'},
                        {icon:'🔥',title:'Streak Hàng Ngày',desc:'Duy trì chuỗi ngày học liên tiếp. Mỗi ngày học ít nhất 1 thẻ để giữ streak – động lực mỗi buổi sáng.',color:'orange'},
                        {icon:'📊',title:'Lộ Trình N5–N1',desc:'Nội dung bám sát đề thi JLPT. Từ vựng, ngữ pháp, Hán tự được sắp xếp theo từng cấp độ rõ ràng.',color:'emerald'},
                    ]" :key="i" class="reveal group p-7 rounded-3xl bg-white dark:bg-white/3 border border-gray-100 dark:border-white/8 hover:border-indigo-200 dark:hover:border-white/20 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-400">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">{{ f.icon }}</div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ f.title }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ f.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- STREAK HIGHLIGHT -->
        <section class="py-24 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="reveal grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <p class="text-sm font-bold text-orange-500 uppercase tracking-widest mb-4">Streak · Duy Trì Động Lực</p>
                        <h2 class="text-4xl font-black mb-5 leading-tight">Học mỗi ngày,<br><span class="bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">không bao giờ bỏ cuộc.</span></h2>
                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-6">Streak theo dõi chuỗi ngày học liên tiếp của bạn. Chỉ cần ôn ít nhất 1 thẻ flashcard mỗi ngày là duy trì được streak. Mất streak đồng nghĩa với bắt đầu lại từ 0 – đủ để tạo thói quen học bền vững.</p>
                        <ul class="space-y-3">
                            <li v-for="item in ['🔥 Streak tính theo ngày dương lịch','📅 Nhắc nhở hàng ngày không để quên','🏆 Hiển thị streak dài nhất từ trước đến nay','⚡ Combo bonus khi học nhiều ngày liên tiếp']" :key="item" class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                                <span>{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-orange-50 to-pink-50 dark:from-orange-900/20 dark:to-pink-900/20 border border-orange-100 dark:border-orange-500/20 rounded-3xl p-8 text-center">
                            <div class="text-8xl font-black text-orange-500 mb-2">🔥</div>
                            <div class="text-6xl font-black text-gray-900 dark:text-white mb-1">30</div>
                            <div class="text-xl font-semibold text-gray-500 dark:text-gray-400 mb-6">ngày liên tiếp</div>
                            <div class="grid grid-cols-7 gap-1.5">
                                <div v-for="d in 28" :key="d" class="aspect-square rounded-md transition-all duration-300" :class="d <= 22 ? 'bg-orange-400' : d <= 25 ? 'bg-orange-200 dark:bg-orange-700' : 'bg-gray-100 dark:bg-gray-800'"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-4">Lịch học tháng này</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LEVELS – hàng ngang không xuống dòng -->
        <section class="py-24 px-6 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <p class="text-sm font-bold text-emerald-500 uppercase tracking-widest mb-3">Lộ Trình</p>
                    <h2 class="text-4xl md:text-5xl font-black mb-4">
                        <span class="bg-gradient-to-r from-emerald-500 to-teal-500 bg-clip-text text-transparent">N5</span>
                        <span class="text-gray-400 mx-2">→</span>
                        <span class="bg-gradient-to-r from-rose-500 to-red-500 bg-clip-text text-transparent">N1</span>
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Học theo chuẩn JLPT quốc tế, lộ trình rõ ràng từng cấp</p>
                </div>
                <div class="reveal flex flex-row gap-3 overflow-x-auto pb-2">
                    <div v-for="(lv,i) in [{n:'N5',d:'Người mới',c:'~800 từ',p:100},{n:'N4',d:'Cơ bản',c:'~1,500 từ',p:80},{n:'N3',d:'Trung cấp',c:'~3,750 từ',p:60},{n:'N2',d:'Nâng cao',c:'~6,000 từ',p:40},{n:'N1',d:'Thành thạo',c:'10K+ từ',p:20}]" :key="i"
                        class="flex-1 min-w-[140px] group p-6 rounded-2xl bg-white dark:bg-white/3 border border-gray-100 dark:border-white/8 hover:border-indigo-200 dark:hover:border-white/25 shadow-sm hover:shadow-lg hover:-translate-y-2 transition-all duration-400 text-center whitespace-nowrap">
                        <div class="text-3xl font-black mb-1 bg-gradient-to-b from-gray-900 to-gray-500 dark:from-white dark:to-gray-500 bg-clip-text text-transparent group-hover:from-indigo-600 group-hover:to-pink-500 dark:group-hover:from-indigo-300 dark:group-hover:to-pink-300 transition-all duration-400">{{ lv.n }}</div>
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">{{ lv.d }}</div>
                        <div class="text-xs text-gray-400 mb-4">{{ lv.c }}</div>
                        <div class="h-1 rounded-full bg-gray-100 dark:bg-white/8 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 transition-all duration-700" :style="`width:${lv.p}%`"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section class="py-24 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <p class="text-sm font-bold text-violet-500 uppercase tracking-widest mb-3">Quy Trình</p>
                    <h2 class="text-4xl md:text-5xl font-black mb-4">Chỉ <span class="bg-gradient-to-r from-violet-500 to-pink-500 bg-clip-text text-transparent">15 Phút</span> Mỗi Ngày</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Học đều đặn, tiến bộ thấy rõ sau mỗi tuần</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div v-for="(s,i) in [
                        {n:'01',t:'Chọn Cấp Độ',d:'Bắt đầu từ N5 hoặc cấp phù hợp.'},
                        {n:'02',t:'Học Flashcard',d:'Ôn từ vựng & Hán tự với FSRS.'},
                        {n:'03',t:'Làm Bài Tập',d:'Ghép câu, điền chữ, luyện nghe.'},
                        {n:'04',t:'Duy Trì Streak',d:'Học mỗi ngày, không bao giờ bỏ.'},
                    ]" :key="i" class="reveal group p-6 rounded-2xl bg-white dark:bg-white/3 border border-gray-100 dark:border-white/8 hover:border-violet-200 dark:hover:border-white/20 shadow-sm hover:shadow-lg hover:-translate-y-2 transition-all duration-400">
                        <div class="text-5xl font-black text-gray-100 dark:text-white/8 mb-4 group-hover:text-violet-100 dark:group-hover:text-violet-500/20 transition-colors select-none">{{ s.n }}</div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ s.t }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ s.d }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CATEGORY HIGHLIGHT -->
        <section class="py-24 px-6 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 reveal">
                    <p class="text-sm font-bold text-pink-500 uppercase tracking-widest mb-3">Nội Dung Học</p>
                    <h2 class="text-4xl md:text-5xl font-black mb-4">3 Mảng <span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">Kiến Thức</span> Cốt Lõi</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-5 reveal">
                    <div v-for="c in [
                        {icon:'📚',title:'Từ Vựng',desc:'Học từ theo chủ đề, mỗi từ có phiên âm, nghĩa, câu ví dụ cụ thể. Ôn lại với flashcard FSRS.',color:'from-indigo-500 to-violet-500'},
                        {icon:'📝',title:'Ngữ Pháp',desc:'Mỗi điểm ngữ pháp đi kèm ví dụ thực tế. Luyện tập qua bài tập ghép câu để nắm chắc cấu trúc.',color:'from-pink-500 to-rose-500'},
                        {icon:'漢',title:'Hán Tự',desc:'Học Kanji theo JLPT từ N5 tới N1. Mỗi Hán tự có âm đọc On/Kun, nghĩa và ví dụ câu điển hình.',color:'from-amber-500 to-orange-500'},
                    ]" :key="c.title" class="group p-7 rounded-3xl bg-white dark:bg-white/3 border border-gray-100 dark:border-white/8 hover:border-pink-200 dark:hover:border-white/20 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-400">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-xl mb-4 bg-gradient-to-br transition-transform duration-300 group-hover:scale-110" :class="c.color">{{ c.icon }}</div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ c.title }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ c.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-24 px-6">
            <div class="max-w-3xl mx-auto text-center reveal">
                <div class="relative p-12 rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-indigo-600/10 dark:to-pink-600/10 border border-indigo-100 dark:border-white/10">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-px bg-gradient-to-r from-transparent via-indigo-400 to-transparent"></div>
                    <div class="text-5xl mb-6">🌸</div>
                    <h2 class="text-4xl md:text-5xl font-black mb-4">Bắt Đầu Hành Trình<br><span class="bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Ngay Hôm Nay</span></h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">Miễn phí · Học thử ngay không cần tài khoản · Bắt đầu N5 ngay bây giờ</p>
                    <Link :href="route('courses.index')" class="inline-block px-10 py-4 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-2xl font-black text-lg text-white shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                        Học thử miễn phí →
                    </Link>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="py-8 px-6 border-t border-gray-100 dark:border-white/5 text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span>🌸</span><span class="font-black text-gray-700 dark:text-gray-300">Niholo</span>
            </div>
            <p class="text-sm text-gray-400">Học tiếng Nhật đúng cách · JLPT N5 ~ N1</p>
        </footer>
    </div>
</template>

<style scoped>
.animate-float { animation: float 7s ease-in-out infinite; }
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(-3deg); }
    50% { transform: translateY(-16px) rotate(3deg); }
}
.animate-blob { animation: blob 6s ease-in-out infinite; }
@keyframes blob {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.2); opacity: 1; }
}
.reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s cubic-bezier(.16,1,.3,1), transform .6s cubic-bezier(.16,1,.3,1); }
.reveal.in-view { opacity: 1; transform: translateY(0); }
.bg-clip-text { -webkit-background-clip: text; background-clip: text; }
</style>
