<template>
    <AppLayout>
        <div class="max-w-9xl mx-auto mb-10">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <Datatables>
                    <template #title>
                        Liste des espaces
                        <span class="font-medium">({{ classRooms.total }})</span>
                    </template>

                    <template #headerButtons>
                        <i @click.prevent="openSearchModal" class="fad fa-search cursor-pointer mr-3"></i>
                        <i  @click.prevent="openModal" class="fad fa-plus-circle cursor-pointer"></i>
                    </template>

                    <template #tableHeader>
                        <th>#</th>
                        <th>Libéllé</th>
                        <th>Type</th>
                        <th>Instituteur</th>
                        <th>Salle</th>
                        <th>&nbsp;</th>
                    </template>

                    <template #tableBody>
                        <tr v-for="(classRoom, index) in classRooms.data" :key="classRoom.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ classRoom.name }}</td>
                            <td>
                                {{ classRoom.type.name }}
                            </td>
                            <td>
                                {{ classRoom.master.name }}
                            </td>
                            <td>
                                {{ classRoom.room.name }}
                            </td>
                            <td>
                                <SecondaryButton @click.prevent="openModal(classRoom)">
                                    <span class="fa fa-pencil"></span>
                                </SecondaryButton>
                                <!--DangerButton class="ml-4" @click.prevent="openModal(room)">
                                    <span class="fa fa-trash"></span>
                                </DangerButton-->
                            </td>
                        </tr>
                    </template>
                </Datatables>

                <Pagination :links="classRooms.links" />
            </div>
        </div>

        <DialogModal :show="searchModal" @close="closeSearchModal()" max-width="xl">
            <template #title>Rechercher un salle de classe</template>

            <template #content>
                <GlobalFilter @search-launched="closeSearchModal()" />
            </template>
        </DialogModal>

        <DialogModal :show="formModal" @close="closeModal()" max-width="xl">
            <template #title>Création d'une salle de classe</template>
            <template #content>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2"
                    >
                        <JetLabel for="name" value="Libéllé" />
                        <JetInput
                            v-model="form.name"
                            type="text"
                            placeholder="Entrez le libéllé de la classe. Ex: (CP1 A)" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="type" value="Types de classe" />
                        <Multiselect
                            v-model="form.type"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="types"
                        />
                        <InputError :message="form.errors.type" class="mt-2" />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="room" value="Salle utilisez" />
                        <Multiselect
                            v-model="form.room"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="rooms"
                        />
                        <InputError :message="form.errors.room" class="mt-2" />
                    </div>
                </div>
            </template>
            <template #footer>
                <PrimaryButton @click="createRoom">
                    Créer
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
    classRooms: Object,
    types: Array,
    rooms: Array,
})

const form = useForm({
    name: null,
    type: null,
    room: null
})

const searchModal = ref(false)
const formModal = ref(false)

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
    ref(formModal).value = true
}

const createRoom = async () => {
    form.post(appRoute('classrooms.store'), {
        errorBag: 'createRoom',
        preserveScroll: true,
        onSuccess: async function() {
            form.clearErrors();
            form.reset();
            await toast('success', 'Classe crée avec succès.');
        }
    });
};
</script>
