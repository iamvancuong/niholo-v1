<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 py-4">
                <div class="h-24 w-24 shrink-0 rounded-full bg-pastel-blue flex items-center justify-center text-4xl font-black text-gray-900 shadow-[6px_6px_0px_rgba(0,0,0,1)] border-4 border-black">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                </div>
                <div class="text-center sm:text-left">
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-1">
                        {{ $page.props.auth.user.name }}
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium flex items-center justify-center sm:justify-start gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $page.props.auth.user.email }}
                    </p>
                    <div class="mt-3 inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-pastel-yellow text-gray-900 border-2 border-black text-xs font-black shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                        <span class="w-2 h-2 rounded-full bg-black animate-pulse"></span>
                        Niholo Member
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12 bg-[#f8f9fa] min-h-screen">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <div class="bg-white p-6 sm:p-10 border-4 border-black sm:rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-4 h-full bg-pastel-blue border-r-4 border-black"></div>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl ml-4"
                    />
                </div>

                <div class="bg-white p-6 sm:p-10 border-4 border-black sm:rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-4 h-full bg-pastel-yellow border-r-4 border-black"></div>
                    <UpdatePasswordForm class="max-w-xl ml-4" />
                </div>

                <div class="bg-white p-6 sm:p-10 border-4 border-black sm:rounded-3xl shadow-[8px_8px_0px_rgba(0,0,0,1)] relative overflow-hidden bg-red-50">
                    <div class="absolute top-0 left-0 w-4 h-full bg-red-400 border-r-4 border-black"></div>
                    <DeleteUserForm class="max-w-xl ml-4" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
