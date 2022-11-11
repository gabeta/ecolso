<template>
    <AppLayout>
        <div class="max-w-9xl mx-auto mb-10">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <Datatables>
                    <template #title>
                        Liste des espaces
                        <span class="font-medium">({{ rooms.total }})</span>
                    </template>

                    <template #headerButtons>
                        <i @click.prevent="openSearchModal" class="fad fa-search cursor-pointer mr-3"></i>
                        <i  @click.prevent="openAddModal" class="fad fa-plus-circle cursor-pointer"></i>
                    </template>

                    <template #tableHeader>
                        <th>#</th>
                        <th>Libéllé</th>
                        <th>Type</th>
                        <th>&nbsp;</th>
                    </template>

                    <template #tableBody>
                        <tr v-for="(room, index) in rooms.data" :key="room.id">
                            <td>{{ index + 1 }}</td>
                        </tr>
                    </template>
                </Datatables>

                <Pagination :links="rooms.links" />
            </div>
        </div>

        <DialogModal :show="searchModal" @close="closeSearchModal()" max-width="xl">
            <template #title>Rechercher un espace</template>

            <template #content>
                <GlobalFilter @search-launched="closeSearchModal()" />
            </template>
        </DialogModal>
        <DialogModal :show="addModal" @close="closeAddModal()" max-width="xl">
            <template #title>Création d'un espace</template>

        </DialogModal>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue"
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datatables from '@/Components/Datatables.vue';
import GlobalFilter from '@/Components/GlobalFilter.vue'
import DialogModal from '@/Components/DialogModal.vue'

defineProps({
    rooms: Object
})

const searchModal = ref(false)
const addModal = ref(false)

const closeSearchModal = () => {
    ref(searchModal).value = false
}

const openSearchModal = () => {
    ref(searchModal).value = true
}

const closeAddModal = () => {
    ref(addModal).value = false
}

const openAddModal = () => {
    ref(addModal).value = true
}
</script>
