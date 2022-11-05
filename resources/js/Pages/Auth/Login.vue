<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <auth-layout title="Ravi de vous revoir.">
        <div>
            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
        </div>
        <form @submit.prevent="submit">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="email">Adresse mail</label>
                    <input id="email" class="form-input w-full"
                           type="email" v-model="form.email" required autofocus />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="password">Mot de passe</label>
                    <input id="password" class="form-input w-full"
                           type="password" v-model="form.password" required autocomplete="current-password"  />
                </div>
            </div>
            <div class="mt-4 mr-1">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox">
                    <span class="text-sm ml-2">Se souvenir de moi</span>
                </label>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="mr-1">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                          class="text-sm underline hover:no-underline">Mot de passe oublié ?
                    </Link>
                </div>
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3">
                    Se connecter
                </button>
            </div>
        </form>
        <!-- Footer -->
        <div class="pt-5 mt-6 border-t border-gray-200">
            <div class="text-sm">
                Vous n'avez pas de compte ?
            </div>
            <!-- Warning -->
            <div class="mt-5">
                <div class="bg-yellow-100 text-yellow-600 px-3 py-2 rounded">
                    <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                    </svg>
                    <span class="text-sm">
                        Veuillez contacter les administrateurs de votre IEP.
                    </span>
                </div>
            </div>
        </div>
    </auth-layout>
</template>
