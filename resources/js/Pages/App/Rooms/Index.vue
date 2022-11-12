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
                            <td>{{ room.name }}</td>
                            <td></td>
                            <td></td>
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
            <template #content>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2"
                    >
                        <JetLabel for="name" value="Libéllé" />
                        <JetInput
                            v-model="form.name"
                            type="text"
                            placeholder="Entrez le libéllé de l'espace" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="types" value="Types de l'espace" />
                        <Multiselect
                            v-model="form.types"
                            mode="tags"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="types"
                        />
                        <InputError :message="form.errors.types" class="mt-2" />
                    </div>
                </div>
            </template>
            <template #footer>
                <PrimaryButton @click="createRoom">
                    <template #icon><i class="fad fa-search text-xs ml-1"></i></template> Ajouter
                </PrimaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue"
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Datatables from '@/Components/Datatables.vue';
import GlobalFilter from '@/Components/GlobalFilter.vue'
import DialogModal from '@/Components/DialogModal.vue'
import JetLabel from '@/Components/InputLabel.vue'
import JetInput from '@/Components/TextInput.vue'
import Multiselect from '@vueform/multiselect'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { toast } from '@/Utils/utils.js'
import InputError from '@/Components/InputError.vue';

defineProps({
    rooms: Object,
    types: Array
})

console.log(appRoute('rooms.store'))

const form = useForm({
    name: null,
    types: []
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

const createRoom = async () => {
    form.post(appRoute('rooms.store'), {
        errorBag: 'createRoom',
        preserveScroll: true,
        onSuccess: async function() {
            form.clearErrors();
            form.reset();
            await toast('success', 'Espace crée avec succès.');
        }
    });
};
</script>
