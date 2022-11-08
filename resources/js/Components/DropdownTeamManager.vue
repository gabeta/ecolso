<template>
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <div class="ml-3 relative">
            <!-- Teams Dropdown -->
            <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                            {{ $page.props.current_year.name }}

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <div class="w-60">
                        <template v-if="$page.props.jetstream.hasTeamFeatures">

                            <!--jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                                Team Settings
                            </jet-dropdown-link-->

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Année scolaire
                            </div>

                            <template v-for="year in $page.props.all_years" :key="year.id">
                                <Link :href="route('app.dashboard', {'team': $page.props.current_team, 'year': year.slug})">
                                    <jet-dropdown-link as="button">
                                        <div class="flex items-center">
                                            <svg v-if="year.is_current" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <div>{{ year.name }}</div>
                                        </div>
                                    </jet-dropdown-link>
                                </Link>
                            </template>
                        </template>
                    </div>
                </template>
            </jet-dropdown>
        </div>
    </div>
</template>

<script>
    import JetDropdown from '@/Components/Dropdown.vue'
    import JetDropdownLink from '@/Components/DropdownLink.vue'
    import {Link} from "@inertiajs/inertia-vue3";

    export default {
        components: {
            JetDropdown,
            JetDropdownLink,
            Link,
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                }, function () {
                    this.$emit('close-modal')
                })
            },
        }
    }
</script>

<style scoped>

</style>
