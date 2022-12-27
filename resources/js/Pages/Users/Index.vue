<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    users: Object
})

</script>

<template>
    <MainLayout>
        <div class="flex justify-between">
            <h4 class="text-2xl font-bold dark:text-white">
                Liste des utilisateurs
            </h4>
            <div>
                <Link :href="route('teams.create')" class="text-white bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#050708]/40 dark:focus:ring-gray-600 mr-2">
                    Ajouter un nouvel utilisateur
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd">
                        </path>
                    </svg>
                </Link>
            </div>
        </div>
        <hr class="m-4">
        <div class="grid grid-cols-6 gap-4">

        </div>
    </MainLayout>
</template>
