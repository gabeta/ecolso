<template>
    <div>
        <div class="flex justify-between bg-primary p-2 text-white tracking-widest">
            <div class="justify-start">
                <slot name="title" />
            </div>

            <div class="justify-end">
                <slot name="headerButtons" />
            </div>
        </div>
        <div class="bg-white p-2" v-if="hasSearch">
            <span class="font-semibold text-sm mr-2">Critères de recherche:</span>
            <span v-for="(search, index) in searchParams" :key="index">
                <span class="px-2 py-1 text-xs rounded-full text-white bg-red-600 mr-2" v-if="search.value">
                    {{ search.label }} : {{ search.value }}
                    <i @click="removeSearch(index)" class="fad fa-times-circle ml-2 cursor-pointer"></i>
                </span>
            </span>
            <span v-for="(filter, index) in filters" :key="index">
                <span v-if="filter.value">
                    <span  v-if="Array.isArray(filter.value)">
                        <span v-for="v in filter.value" :key="v"
                            class="px-2 py-1 text-xs rounded-full text-white bg-red-600 mr-2"
                        >
                            {{ filter.label }} : {{ filter.options[v] }}
                            <i @click="removeFilter(index, v)" class="fad fa-times-circle ml-2 cursor-pointer"></i>
                        </span>
                    </span>
                    <span v-else class="px-2 py-1 text-xs rounded-full text-white bg-red-600 mr-2">
                        {{ filter.label }} : {{ filter.options[filter.value] }}
                        <i @click="removeFilter(index)" class="fad fa-times-circle ml-2 cursor-pointer"></i>
                    </span>
                </span>
            </span>
        </div>
        <table class="bg-white w-full">
            <thead class="bg-gray-200">
                <slot name="tableHeader" />
            </thead>

            <tbody>
                <slot name="tableBody" />
            </tbody>
        </table>
    </div>
</template>

<script>
    import qs from "qs";
    import InteractWithFilterMixins from "@/Mixins/InteractWithFilterMixins.vue";

    export default {
        data() {
            return {
                searchParams: [],
                filters: [],
                hasSearch: null
            }
        },

        mixins: [InteractWithFilterMixins],

        mounted() {
            this.searchParams =  Object.assign({}, this.$page.props.queryBuilderProps.search)
            this.filters = Object.assign({}, this.$page.props.queryBuilderProps.filters)
            this.getSearchData()
        },

        methods: {
            getSearchData() {
                if (window.location.search) {
                    const params = qs.parse(window.location.search.substring(1))
                    this.hasSearch = null
                    if (params.filter) {
                        this.hasSearch = params.filter
                        for (const [key, value] of Object.entries(params.filter)) {
                            if (this.searchParams[key]) {
                                this.searchParams[key].value = value
                            }
                            if (this.filters[key]) {
                                let filterValue = ''
                                if (this.filters[key].config.mode === 'tags') {
                                    filterValue = value.split(',')
                                } else {
                                    filterValue =  value
                                }
                                this.filters[key].value = filterValue
                            }
                        }
                    }
                }
            },
            removeSearch(index) {
                this.$page.props.queryBuilderProps.search[index].value = null
                this.searchParams[index].value = null
                this.search()
            },
            removeFilter(index, val = null) {
                let filter = null
                if (Array.isArray(this.filters[index].value)) {
                    filter = this.filters[index].value.filter(v => v !== val)
                } else {
                    filter = null
                }
                this.filters[index].value = filter
                this.$page.props.queryBuilderProps.filters[index].value = filter
                this.search(false)
            }
        },

        watch: {
            $page: function (oldValue, newValue) {
                this.getSearchData()
            }
        }
    }
</script>

<style scoped>
    table >>> th {
        font-size: 0.7rem;
        line-height: 1rem;
        padding-top: 0.28rem;
        padding-bottom: 0.28rem;
        padding-left: .77rem;
        padding-right: .77rem;
        text-align: center;
        font-weight: bold;
        --tw-text-opacity: 1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    tbody >>> td {
        text-align: center;
        --tw-text-opacity: 1;
        color: rgba(107, 114, 128, var(--tw-text-opacity));
        border-bottom: 1px solid #e7e7e7;
        font-size: 0.87rem;
        line-height: 1.25rem;
        padding-top: .37rem;
        padding-bottom: .37rem;
        padding-left: .77rem;
        padding-right: .77rem;
        white-space: nowrap;
    }

    tbody >>> tr:hover td {
        --tw-bg-opacity: 1;
        background-color: rgba(229, 229, 229, var(--tw-bg-opacity));
    }
</style>
