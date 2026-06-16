<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    guest_reviews: null,
});

const submit = () => {
    // Collect guest progress from localStorage
    try {
        const reviews = localStorage.getItem('guest_reviews');
        if (reviews) {
            form.guest_reviews = JSON.parse(reviews);
        }
    } catch (e) {
        // Ignore
    }

    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            // Clear localStorage on success
            localStorage.removeItem('guest_reviews');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <!-- Tab Switcher -->
        <div class="flex border-4 border-black rounded-2xl overflow-hidden mb-8 shadow-[2px_2px_0px_rgba(0,0,0,1)] sm:shadow-[4px_4px_0px_rgba(0,0,0,1)] bg-white">
            <Link :href="route('login')" class="flex-1 py-2 sm:py-3 text-center font-black text-sm sm:text-lg uppercase transition-colors hover:bg-gray-100 text-gray-500 hover:text-black border-r-4 border-black">
                Đăng Nhập
            </Link>
            <div class="flex-1 py-2 sm:py-3 text-center font-black text-sm sm:text-lg uppercase bg-[#aaed5a] cursor-default text-black">
                Đăng Ký
            </div>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-6 flex items-center justify-end">

                <PrimaryButton
                    class="ms-4 w-full sm:w-auto"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Tạo tài khoản
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
