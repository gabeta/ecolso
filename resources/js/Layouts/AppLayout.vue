<template>
    <div class="flex h-screen overflow-hidden">
        <SideBar :sidebar-open="sidebarOpen" @close-sidebar="sidebarOpen = false" />

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <HeaderBar :sidebar-open="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
    import { defineComponent, ref } from 'vue'
    import SideBar from '@/Components/SideBar.vue'
    import HeaderBar from '@/Components/HeaderBar.vue'

    export default defineComponent({
        components: {
            SideBar,
            HeaderBar,
        },

        setup() {
            const sidebarOpen = ref(false)

            return {
                sidebarOpen,
            }
        }
    })
</script>

<style scoped>

</style>
