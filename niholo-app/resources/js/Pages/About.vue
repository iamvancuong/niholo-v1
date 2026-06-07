<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen font-sans bg-[#f4f7f4] selection:bg-yellow-300 selection:text-black">
        <Head title="Về Co-founder – Văn Cường" />

        <!-- NAVBAR -->
        <nav class="fixed top-0 inset-x-0 z-50 px-8 py-4 flex items-center justify-between bg-white border-b-4 border-black">
            <Link href="/" class="flex items-center gap-2">
                <span class="text-xl font-black tracking-tight uppercase px-3 py-1.5 rounded-lg text-black bg-pastel-yellow border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">🌸 NIHOLO</span>
            </Link>
            <div class="flex items-center gap-6 font-bold text-base text-gray-800">
                <Link href="/" class="hover:text-pastel-orange transition-colors">Trang chủ</Link>
                <Link :href="route('courses.index')" class="hover:text-pastel-orange transition-colors">Lộ trình</Link>
            </div>
        </nav>

        <main class="pt-24 pb-12 px-4 lg:px-8 max-w-[85rem] w-full mx-auto">
            <!-- HERO SECTION: Co-founder Intro -->
            <section class="bg-white border-4 border-black rounded-3xl p-6 lg:p-8 shadow-[8px_8px_0px_rgba(0,0,0,1)] relative z-10 flex flex-col md:flex-row items-stretch gap-6 lg:gap-8 h-auto min-h-[calc(100vh-8rem)] lg:h-[calc(100vh-8rem)] lg:min-h-[600px] mt-2">
                <!-- Left: Image -->
                <div class="w-full md:w-5/12 shrink-0 relative group h-[350px] lg:h-auto">
                    <div class="absolute inset-0 bg-pastel-blue border-4 border-black rounded-3xl translate-x-2 translate-y-2 transition-transform group-hover:translate-x-4 group-hover:translate-y-4"></div>
                    <div class="relative w-full h-full bg-gray-200 border-4 border-black rounded-3xl overflow-hidden z-10">
                        <!-- User Image (enhanced via CSS for sharpness) -->
                        <img src="/images/vancuong.jpg" alt="Văn Cường - Co-founder Niholo" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1) brightness(1.05); object-position: center 20%;" onerror="this.src='https://via.placeholder.com/600x800?text=Van+Cuong+Image'">
                    </div>
                    <!-- Decorative sticker -->
                    <div class="absolute -bottom-4 -right-4 md:-bottom-5 md:-right-5 text-5xl rotate-12 z-20 group-hover:-rotate-12 transition-transform duration-300">💻</div>
                </div>

                <!-- Right: Information -->
                <div class="w-full md:w-7/12 flex flex-col justify-center py-2 overflow-y-auto pr-2" style="scrollbar-width: thin;">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border-2 border-black bg-pastel-yellow font-black text-xs mb-3 shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                            CO-FOUNDER / DEVELOPER
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-black mb-4 uppercase tracking-tight text-gray-900">Văn Cường</h1>
                        
                        <div class="space-y-3 text-base lg:text-lg font-bold text-gray-700 leading-relaxed mb-6">
                            <p>
                                Chào bạn! Mình là Trương Văn Cường, sinh năm 2003 tại mảnh đất nắng gió Quảng Trị. Hiện tại, mình đang theo đuổi con đường Công nghệ thông tin (IT) với niềm đam mê xây dựng các sản phẩm thực tế mang lại giá trị cho cộng đồng.
                            </p>
                            <p>
                                Là một Developer, mục tiêu của mình không chỉ dừng lại ở việc viết code. Mình khao khát được làm chủ và sử dụng thật tốt tiếng Nhật trong cả cuộc sống lẫn công việc, qua đó mở rộng thế giới quan và học hỏi những tư duy đa chiều. Đó cũng chính là lý do mình cùng các cộng sự tạo nên Niholo – nơi mình gửi gắm tư duy công nghệ để mang đến cho bạn một trải nghiệm học tiếng Nhật thông minh và hiệu quả nhất.
                            </p>
                            <p>
                                Mình tin rằng, bất kể chúng ta làm công việc gì hay học ngôn ngữ nào, điều quan trọng nhất vẫn là sống hướng đến những giá trị đạo đức tốt đẹp và không ngừng vươn lên.
                            </p>
                            <p class="text-black italic">Rất vui được kết nối và đồng hành cùng bạn!</p>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="flex flex-wrap gap-3 mt-auto pt-4 border-t-4 border-black border-dashed">
                        <a href="https://www.facebook.com/iamvancuong" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-blue-100 border-4 border-black rounded-full font-black text-sm text-blue-900 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>
                            Facebook
                        </a>
                        <a href="https://www.tiktok.com/@iamvancuong" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-black border-4 border-black rounded-full font-black text-sm text-white shadow-[4px_4px_0px_#ff0050] hover:-translate-y-1 transition-transform">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.04-.1z"/></svg>
                            TikTok
                        </a>
                        <a href="https://www.youtube.com/@iamvancuong" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-red-100 border-4 border-black rounded-full font-black text-sm text-red-700 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.582 6.186a2.665 2.665 0 0 0-1.875-1.884C18.053 3.86 12 3.86 12 3.86s-6.053 0-7.707.442a2.665 2.665 0 0 0-1.875 1.884C2 7.854 2 12 2 12s0 4.146.418 5.814a2.665 2.665 0 0 0 1.875 1.884C5.947 20.14 12 20.14 12 20.14s6.053 0 7.707-.442a2.665 2.665 0 0 0 1.875-1.884C22 16.146 22 12 22 12s0-4.146-.418-5.814zM9.917 15.352V8.648L15.683 12l-5.766 3.352z"/></svg>
                            YouTube
                        </a>
                        <a href="https://www.linkedin.com/in/iamvancuong" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-indigo-100 border-4 border-black rounded-full font-black text-sm text-indigo-900 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">
                            LinkedIn
                        </a>
                        <a href="https://www.instagram.com/iamvancuong" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-pink-100 border-4 border-black rounded-full font-black text-sm text-pink-900 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-transform">
                            Instagram
                        </a>
                    </div>
                </div>
            </section>

            <!-- BLOG / DIARY SECTION -->
            <section class="mt-24">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-black uppercase mb-4" style="text-shadow: 2px 2px 0px #B6FABF;">Góc Nhìn & Trải Nghiệm</h2>
                    <p class="text-xl font-bold text-gray-600">Nhật ký hành trình phát triển bản thân và tư duy.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1: Tư duy -->
                    <div class="bg-pastel-pink border-4 border-black p-8 rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all flex flex-col">
                        <div class="text-5xl mb-6">🌱</div>
                        <h3 class="text-2xl font-black mb-4 uppercase">Tư duy học ngoại ngữ</h3>
                        <p class="font-bold text-gray-800 text-lg flex-1">
                            Học ngoại ngữ không phải là cuộc đua nhồi nhét từ vựng, mà là một hành trình mở khóa cách tư duy mới. Ngoại ngữ là công cụ để thấu hiểu văn hóa và kết nối với thế giới. Đừng học vì điểm số, hãy học để sử dụng!
                        </p>
                        <div class="mt-6 pt-4 border-t-2 border-black/20 font-bold text-sm text-gray-600">#Mindset</div>
                    </div>

                    <!-- Card 2: Văn hóa Nhật -->
                    <div class="bg-pastel-yellow border-4 border-black p-8 rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all flex flex-col mt-6 md:mt-0 md:translate-y-6">
                        <div class="text-5xl mb-6">🗻</div>
                        <h3 class="text-2xl font-black mb-4 uppercase">Trải nghiệm & Văn hóa</h3>
                        <p class="font-bold text-gray-800 text-lg flex-1">
                            Sự tỉ mỉ (Omotenashi) và tinh thần cải tiến không ngừng (Kaizen) của người Nhật luôn truyền cảm hứng mạnh mẽ cho mình trong cả việc viết code lẫn cuộc sống thường ngày. Hãy làm tốt từ những điều nhỏ nhất!
                        </p>
                        <div class="mt-6 pt-4 border-t-2 border-black/20 font-bold text-sm text-gray-600">#Culture #Japan</div>
                    </div>

                    <!-- Card 3: Mạng xã hội -->
                    <div class="bg-pastel-blue border-4 border-black p-8 rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:-translate-y-2 hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] transition-all flex flex-col mt-6 md:mt-0">
                        <div class="text-5xl mb-6">🎥</div>
                        <h3 class="text-2xl font-black mb-4 uppercase">Hành trình Xây kênh</h3>
                        <p class="font-bold text-gray-800 text-lg flex-1">
                            Từ những video đầu tiên vụng về đến khi hình thành kênh @iamvancuong, đó là một hành trình học cách truyền đạt giá trị. MXH không chỉ để giải trí, nó là nơi mình lan tỏa năng lượng tích cực và lưu giữ thanh xuân.
                        </p>
                        <div class="mt-6 pt-4 border-t-2 border-black/20 font-bold text-sm text-gray-600">#ContentCreator</div>
                    </div>
                </div>
            </section>

        </main>
        
        <!-- FOOTER (Simplified for About page) -->
        <footer class="py-10 border-t-4 border-black bg-white mt-12 text-center">
            <p class="font-bold text-gray-700">© 2026 Văn Cường (iamvancuong) & Niholo JLPT Platform.</p>
        </footer>
    </div>
</template>
