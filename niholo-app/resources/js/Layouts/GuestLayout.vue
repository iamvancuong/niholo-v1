<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden bg-[#f8f9fa] selection:bg-yellow-300 selection:text-black">
        
        <!-- Background Grid -->
        <div class="absolute inset-0 pointer-events-none select-none z-0" style="background-image: linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px); background-size: 52px 52px;"></div>

        <!-- Decorative Floating Elements -->
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden z-0">
            <span class="absolute text-6xl opacity-20 -rotate-12 animate-float" style="top: 10%; left: 15%; animation-delay: 0s;">🎌</span>
            <span class="absolute text-5xl opacity-20 rotate-12 animate-float" style="top: 20%; right: 10%; animation-delay: 1s;">🌸</span>
            <span class="absolute text-6xl opacity-20 -rotate-6 animate-float" style="bottom: 15%; left: 10%; animation-delay: 2s;">🗻</span>
            <span class="absolute text-5xl opacity-20 rotate-45 animate-float" style="bottom: 25%; right: 15%; animation-delay: 0.5s;">⭐</span>
        </div>

        <div class="relative z-10 mb-8 mt-10 sm:mt-0 text-center">
            <Link href="/" class="inline-block group">
                <ApplicationLogo class="h-24 w-24 fill-current text-black group-hover:scale-110 transition-transform duration-300 drop-shadow-[4px_4px_0px_#aaed5a]" />
            </Link>
            <h1 class="text-center mt-4 text-4xl font-black text-gray-900 tracking-tight uppercase" style="text-shadow: 2px 2px 0px #aaed5a;">Niholo Platform</h1>
        </div>

        <div class="relative z-10 w-full sm:max-w-md px-4 sm:px-0 mt-2">
            <div class="w-full px-8 py-10 bg-white border-4 border-black rounded-3xl shadow-[4px_4px_0px_rgba(0,0,0,1)] sm:shadow-[8px_8px_0px_rgba(0,0,0,1)]">
                <slot />
            </div>
        </div>
    </div>
</template>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(5deg); }
}
.animate-float {
    animation: float 6s ease-in-out infinite;
}
</style>
