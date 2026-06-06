<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const showingNavigationDropdown = ref(false);
const isDark = ref(false);

const toggleTheme = () => {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle('dark', isDark.value);
    localStorage.setItem('niholo-theme', isDark.value ? 'dark' : 'light');
};

import { onMounted } from 'vue';

const isSidebarOpen = ref(true);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
    localStorage.setItem('niholo-sidebar', isSidebarOpen.value ? 'open' : 'closed');
};

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
    if (localStorage.getItem('niholo-sidebar') === 'closed') {
        isSidebarOpen.value = false;
    }
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-[#faf9f6] dark:bg-gray-950 flex transition-colors duration-300">
            
            <!-- Left Sidebar (Desktop) -->
            <aside class="hidden sm:flex flex-col fixed inset-y-0 left-0 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 z-50 transition-all duration-300"
                   :class="isSidebarOpen ? 'w-64' : 'w-20'">
                <div class="p-6 flex items-center justify-between overflow-hidden">
                    <Link :href="route('dashboard')" class="flex items-center gap-2">
                        <ApplicationLogo class="h-10 w-auto flex-shrink-0" />
                        <span v-if="isSidebarOpen" class="font-black text-xl tracking-tight dark:text-white transition-opacity duration-300">NIHOLO</span>
                    </Link>
                </div>
                
                <nav class="flex-1 px-3 space-y-3 mt-2 overflow-hidden" :class="isSidebarOpen ? '' : 'px-2'">
                    <Link :href="route('dashboard')" class="flex items-center gap-3 py-3 rounded-xl text-lg font-bold transition" :class="[route().current('dashboard') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800/50', isSidebarOpen ? 'px-4' : 'px-0 justify-center']" :title="!isSidebarOpen ? 'Tổng quan' : ''">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <span v-if="isSidebarOpen" class="truncate">Tổng quan</span>
                    </Link>
                    <Link :href="route('courses.index')" class="flex items-center gap-3 py-3 rounded-xl text-lg font-bold transition" :class="[route().current('courses.*') || route().current('lessons.*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800/50', isSidebarOpen ? 'px-4' : 'px-0 justify-center']" :title="!isSidebarOpen ? 'Khóa học' : ''">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span v-if="isSidebarOpen" class="truncate">Khóa học</span>
                    </Link>
                    <Link :href="route('exams.index')" class="flex items-center gap-3 py-3 rounded-xl text-lg font-bold transition" :class="[route().current('exams.*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800/50', isSidebarOpen ? 'px-4' : 'px-0 justify-center']" :title="!isSidebarOpen ? 'Đề thi' : ''">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span v-if="isSidebarOpen" class="truncate">Đề thi</span>
                    </Link>
                    <Link :href="route('vault.index')" class="flex items-center gap-3 py-3 rounded-xl text-lg font-bold transition" :class="[route().current('vault.*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800/50', isSidebarOpen ? 'px-4' : 'px-0 justify-center']" :title="!isSidebarOpen ? 'Vault Thẻ' : ''">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span v-if="isSidebarOpen" class="truncate">Vault Thẻ</span>
                    </Link>

                    <div class="flex items-center gap-3 py-3 rounded-xl text-lg font-bold text-gray-400 cursor-not-allowed whitespace-nowrap overflow-hidden transition-all" :class="[isSidebarOpen ? 'px-4' : 'px-0 justify-center']" :title="!isSidebarOpen ? 'AI Sensei (Sắp ra mắt)' : ''">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span v-if="isSidebarOpen" class="truncate">AI Sensei</span>
                        <span v-if="isSidebarOpen" class="ml-auto text-[10px] bg-orange-100 text-orange-600 px-2 py-1 rounded-full flex-shrink-0">Sắp ra mắt</span>
                    </div>
                </nav>

                <!-- Sidebar Toggle Button -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                    <button @click="toggleSidebar" class="flex items-center justify-center w-full p-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition" :title="isSidebarOpen ? 'Thu gọn sidebar' : 'Mở rộng sidebar'">
                        <svg v-if="isSidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </aside>

            <!-- Mobile Top Nav -->
            <div class="sm:hidden fixed top-0 inset-x-0 h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-50 flex items-center justify-between px-4">
                <Link :href="route('dashboard')" class="flex items-center gap-2">
                    <ApplicationLogo class="h-8 w-auto flex-shrink-0" />
                    <span class="font-black text-lg tracking-tight dark:text-white">NIHOLO</span>
                </Link>
                <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="p-2 text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            
            <div v-if="showingNavigationDropdown" class="sm:hidden fixed inset-0 z-40 bg-white dark:bg-gray-900 pt-16">
                <div class="p-4 space-y-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Trang chủ</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('courses.index')" :active="route().current('courses.*') || route().current('lessons.*')">Khóa học</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('exams.index')" :active="route().current('exams.*')">Đề thi</ResponsiveNavLink>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen pt-16 sm:pt-0 transition-all duration-300"
                 :class="isSidebarOpen ? 'sm:ml-64' : 'sm:ml-20'">
                <!-- Top Header -->
                <header class="h-16 px-8 flex items-center justify-between bg-white/0 backdrop-blur-sm sticky top-0 z-30">
                    <div class="flex items-center">
                        <Dropdown align="left" width="48">
                            <template #trigger>
                                <button class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-full bg-white dark:bg-gray-800 shadow-sm hover:shadow transition">
                                    <span class="text-xl">🇯🇵</span>
                                    <span class="font-bold text-gray-700 dark:text-gray-200 text-sm">Các khóa học Niholo</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </template>
                            <template #content>
                                <div class="px-4 py-2 text-sm text-gray-500 font-bold">Tiếng Nhật N5</div>
                            </template>
                        </Dropdown>
                    </div>

                    <div class="flex items-center gap-6">
                        <button @click="toggleTheme" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                            <svg v-if="isDark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                            <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        <div class="flex items-center gap-1 font-bold text-orange-500">
                            🔥 <span class="text-gray-700 dark:text-gray-200">0</span>
                        </div>
                        
                        <Dropdown v-if="$page.props.auth.user" align="right" width="48">
                            <template #trigger>
                                <button class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">Hồ sơ</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Đăng xuất</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden relative">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
