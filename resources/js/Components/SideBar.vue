<template>
    <div>
        <!-- Sidebar backdrop (mobile only) -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
             :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true"></div>

        <!-- Sidebar -->
        <div
            id="sidebar"
            ref="sidebar"
            class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-gray-800 p-4 transition-all duration-200 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
        >

            <!-- Sidebar header -->
            <div class="flex justify-between mb-10 pr-3 sm:px-2">
                <!-- Close button -->
                <button
                    ref="trigger"
                    class="lg:hidden text-gray-500 hover:text-gray-400"
                    @click.stop="$emit('close-sidebar')"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Close sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"/>
                    </svg>
                </button>
                <!-- Logo -->
                <Link :href="route('dashboard')" class="block">
                    <svg width="32" height="32" viewBox="0 0 32 32">
                        <defs>
                            <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                                <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%"/>
                                <stop stop-color="#A5B4FC" offset="100%"/>
                            </linearGradient>
                            <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                                <stop stop-color="#38BDF8" stop-opacity="0" offset="0%"/>
                                <stop stop-color="#38BDF8" offset="100%"/>
                            </linearGradient>
                        </defs>
                        <rect fill="#6366F1" width="32" height="32" rx="16"/>
                        <path
                            d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z"
                            fill="#4F46E5"/>
                        <path
                            d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z"
                            fill="url(#logo-a)"/>
                        <path
                            d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z"
                            fill="url(#logo-b)"/>
                    </svg>
                </Link>
            </div>

            <!-- Links -->
            <div class="space-y-8">
                <!-- Pages group -->
                <div>
                    <h3 class="text-xs uppercase text-gray-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                              aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                    </h3>
                    <ul class="mt-3">
                        <li class="px-3 py-2 rounded-sm mb-1 last:mb-0"
                            :class="route().current('app.dashboard') && 'bg-gray-900'">
                            <Link :href="appRoute('dashboard')"
                                  class="block text-gray-200 hover:text-white truncate transition duration-150"
                                  :class="route().current('saas.dashboard') && 'hover:text-gray-200'">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-gray-400"
                                              :class="route().current('app.dashboard') && '!text-indigo-500'"
                                              d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z"/>
                                        <path class="fill-current text-gray-600"
                                              :class="route().current('app.dashboard') && 'text-indigo-600'"
                                              d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z"/>
                                        <path class="fill-current text-gray-400"
                                              :class="route().current('app.dashboard') && 'text-indigo-200'"
                                              d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z"/>
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        Tableau de bord
                                    </span>
                                </div>
                            </Link>
                        </li>

                        <side-bar-link-group v-slot="parentLink" :activeCondition="route().current('settings.*')">
                            <a class="block text-gray-200 hover:text-white truncate transition duration-150"
                               :class="route().current('app.settings.*') && 'hover:text-gray-200'" href="#0"
                               @click.prevent="sidebarExpanded ? parentLink.handleClick() : sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path class="fill-current text-gray-600"
                                                  :class="route().current('app.settings.*') && 'text-indigo-500'"
                                                  d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z"/>
                                            <path class="fill-current text-gray-400"
                                                  :class="route().current('app.settings.*') && 'text-indigo-300'"
                                                  d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z"/>
                                            <path class="fill-current text-gray-600"
                                                  :class="route().current('app.settings.*') && 'text-indigo-500'"
                                                  d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z"/>
                                            <path class="fill-current text-gray-400"
                                                  :class="route().current('app.settings.*') && 'text-indigo-300'"
                                                  d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Paramètres</span>
                                    </div>
                                    <div class="flex shrink-0 ml-2">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400"
                                             :class="parentLink.expanded && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1" :class="!parentLink.expanded && 'hidden'">
                                    <li class="my-1 last:mb-0">
                                        <Link :href="appRoute('settings.general')"
                                              class="block text-gray-400 hover:text-gray-200 transition duration-150 truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Générale
                                            </span>
                                        </Link>
                                    </li>
                                    <li class="my-1 last:mb-0">
                                        <Link href="/"
                                              class="block text-gray-400 hover:text-gray-200 transition duration-150 truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Personnelles
                                            </span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </side-bar-link-group>
                    </ul>
                </div>
            </div>

            <!-- Expand / collapse button -->
            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
                <div class="px-3 py-2">
                    <button @click.prevent="sidebarExpanded = !sidebarExpanded">
                        <span class="sr-only">Expand / collapse sidebar</span>
                        <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                            <path class="text-gray-400"
                                  d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z"/>
                            <path class="text-gray-600" d="M3 23H1V1h2z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import {defineComponent, ref, onMounted, onUnmounted, watch} from 'vue'
    import {Link} from '@inertiajs/inertia-vue3';
    import SideBarLinkGroup from "@/Components/SideBarLinkGroup.vue"

    export default defineComponent({
        props: {
            sidebar: Object,
            sidebarOpen: Boolean,
        },

        components: {
            Link,
            SideBarLinkGroup,
        },

        setup(props, {emit}) {
            const trigger = ref(null)
            const sidebar = ref(null)
            const storedSidebarExpanded = localStorage.getItem('sidebar-expanded')
            const sidebarExpanded = ref(storedSidebarExpanded === null ? false : storedSidebarExpanded === 'true')

            // close on click outside
            const clickHandler = ({target}) => {
                if (!sidebar.value || !trigger.value) return
                if (
                    !props.sidebarOpen ||
                    sidebar.value.contains(target) ||
                    trigger.value.contains(target)
                ) return
                emit('close-sidebar')
            }
            // close if the esc key is pressed
            const keyHandler = ({keyCode}) => {
                if (!props.sidebarOpen || keyCode !== 27) return
                emit('close-sidebar')
            }
            onMounted(() => {
                document.addEventListener('click', clickHandler)
                document.addEventListener('keydown', keyHandler)
            })
            onUnmounted(() => {
                document.removeEventListener('click', clickHandler)
                document.removeEventListener('keydown', keyHandler)
            })
            watch(sidebarExpanded, () => {
                localStorage.setItem('sidebar-expanded', sidebarExpanded.value)
                if (sidebarExpanded.value) {
                    document.querySelector('body').classList.add('sidebar-expanded')
                } else {
                    document.querySelector('body').classList.remove('sidebar-expanded')
                }
            })
            return {
                trigger,
                sidebar,
                sidebarExpanded,
            }
        },
    })
</script>

<style scoped>

</style>
