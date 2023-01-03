<template>
    <MainLayout>
        <div class="flex justify-between">
            <h4 class="text-2xl font-bold dark:text-white">
                Liste des utilisateurs ({{ users.total }})
            </h4>
            <div>
                <button class="text-white bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#050708]/40 dark:focus:ring-gray-600 mr-2">
                    Ajouter un nouvel utilisateur
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <hr class="m-4">
        <div class="w-full gap-4">
            <Datatables>
                <template #title>
                </template>

                <template #headerButtons>
                    <i @click.prevent="openSearchModal" class="fad fa-search cursor-pointer mr-3"></i>
                    <i  @click.prevent="openModal" class="fad fa-plus-circle cursor-pointer"></i>
                </template>

                <template #tableHeader>
                    <th>#</th>
                    <th>Nom et prénom</th>
                    <th>Adresse email</th>
                    <th>Numéro de téléphone</th>
                    <th>Role</th>
                    <th>Établissement</th>
                    <th>&nbsp;</th>
                </template>

                <template #tableBody>
                    <tr v-for="(user, index) in users.data" :key="user.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            ...
                        </td>
                        <td>
                            <span v-for="role in user.roles" :key="role.id">{{ role.name }}</span>
                        </td>
                        <td>
                            ...
                        </td>
                        <td>
                            <SecondaryButton>
                                <span class="fa fa-lock"></span>
                            </SecondaryButton>
                            <!--DangerButton class="ml-4" @click.prevent="openModal(room)">
                                <span class="fa fa-trash"></span>
                            </DangerButton-->
                        </td>
                    </tr>
                </template>
            </Datatables>

            <Pagination :links="users.links" />
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import Datatables from '@/Components/Datatables.vue';
import GlobalFilter from '@/Components/GlobalFilter.vue'
import DialogModal from '@/Components/DialogModal.vue'
import JetLabel from '@/Components/InputLabel.vue'
import JetInput from '@/Components/TextInput.vue'

defineProps({
    users: Object
})

</script>
