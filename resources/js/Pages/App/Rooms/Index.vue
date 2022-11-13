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
                        <i  @click.prevent="openModal" class="fad fa-plus-circle cursor-pointer"></i>
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
                            <td>
                                <span v-for="type in room.types" :key="type.id" class="m-1 text-xs inline-flex font-medium bg-light-blue-100 text-light-blue-600 rounded-full text-center px-2.5 py-1 whitespace-nowrap">
                                    {{ type.name }}
                                </span>
                            </td>
                            <td>
                                <SecondaryButton @click.prevent="openModal(room)">
                                    <span class="fa fa-pencil"></span>
                                </SecondaryButton>
                                <!--DangerButton class="ml-4" @click.prevent="openModal(room)">
                                    <span class="fa fa-trash"></span>
                                </DangerButton-->
                            </td>
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
        <DialogModal :show="formModal" @close="closeModal()" max-width="xl">
            <template #title>{{ room.id ? 'Mise à jour ' : 'Création' }} d'un espace</template>
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
                <PrimaryButton @click="submitForm">
                    {{ room.id ? 'Mettre à jour ' : 'Ajouter' }}
                </PrimaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<script setup>
import { ref, reactive } from "vue"
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
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { toast } from '@/Utils/utils.js'
import InputError from '@/Components/InputError.vue';
import * as _ from "underscore"

defineProps({
    rooms: Object,
    types: Array
})

const form = useForm({
    name: null,
    types: []
})

const searchModal = ref(false)
const formModal = ref(false)
const room = ref(null)

const closeSearchModal = () => {
    ref(searchModal).value = false
}

const openSearchModal = () => {
    ref(searchModal).value = true
}

const closeModal = () => {
    ref(formModal).value = false
}

const openModal = (r = null) => {
    if (r) {
        ref(room).value = r
        form.name = r.name
        form.types = _.pluck(r.types, 'id')
    } else {
        ref(room).value = null
        form.name = null
        form.types = []
    }

    ref(formModal).value = true
}

const submitForm = () => {
    if (room.value.id) {
        updateRoom(room.value)
    } else {
        createRoom()
    }
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

const updateRoom = async (r) => {
    form.put(appRoute('rooms.update', {'room': r}), {
        errorBag: 'updateRoom',
        preserveScroll: true,
        onSuccess: async function() {
            form.clearErrors();
            await toast('success', 'Espace mis à jour avec succès.');
        }
    });
};
</script>
