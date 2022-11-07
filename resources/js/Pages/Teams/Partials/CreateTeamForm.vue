<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { toast } from '@/Utils/utils.js'

const form = useForm({
    name: '',
    email: '',
    director: '',
    mobile: '',
    telephone: '',
});

const createTeam = async () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
        onSuccess: async () => {
            await toast('success', 'École crée avec succès.')
        }
    });
};
</script>

<template>
    <FormSection @submitted="createTeam">
        <template #title>
            Formulaire de création
        </template>

        <template #description>

        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Nom de l'école" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="director" value="Nom du directeur" />
                <TextInput
                    id="director"
                    v-model="form.director"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.director" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email de l'école (optionel)" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="mobile" value="Téléphone mobile de l'école" />
                <TextInput
                    id="mobile"
                    v-model="form.mobile"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.mobile" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="telephone" value="Téléphone fix de l'école (optionel)" />
                <TextInput
                    id="telephone"
                    v-model="form.telephone"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError :message="form.errors.telephone" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Créer
            </PrimaryButton>
        </template>
    </FormSection>
</template>
