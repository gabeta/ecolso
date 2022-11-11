<template>
    <nav v-if="links.length > 3" class="my-3 flex items-center justify-center sm:px-6">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key" >
                <div v-if="link.url === null" v-html="link.label"
                    class="mr-1 px-4 p-3 text-sm leading-4 bg-white text-gray-400 border rounded"
                />
                <Link v-else class="mr-1 px-4 p-3 text-sm leading-4 bg-white hover:bg-gray-100
                    focus:bg-secondary-600 focus:text-primary border rounded"
                    :class="{ 'bg-secondary-600 text-primary font-semibold': link.active }" :href="link.url" v-html="link.label"
                />
            </template>
        </div>
    </nav>
</template>

<script setup>
    import {Link} from '@inertiajs/inertia-vue3'

    defineProps({
        links: Array,
    })
</script>