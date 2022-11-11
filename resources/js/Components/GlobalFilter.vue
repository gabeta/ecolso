<template>
    <div class="grid grid-cols-2 gap-4">
        <div v-for="(search, index) in $page.props.queryBuilderProps.search" :key="index"
            :class="'col-span-' + search.config.position"
        >
            <JetLabel :for="search.label" :value="search.label" />
            <JetInput
                :id="search.label"
                :value="search.value"
                :type="search.config.type"
                :placeholder="search.config.placeholder"
                @input="changeSearchValue(index, $event.target.value)"
            />
        </div>
        <div v-for="(filter, index) in $page.props.queryBuilderProps.filters" :key="index"
            :class="'col-span-' + filter.config.position"
        >
            <JetLabel :value="filter.label" />
            <Multiselect
                searchable
                :ref="index"
                v-model="select[index]"
                :options="filter.options"
                :mode="filter.config.mode"
                @change="changeFilterValue(index)"
                :placeholder="filter.config.placeholder"
            />
        </div>
        <div class="col-span-2 text-right">
            <Button @click="search" color="sky">
                <template #icon><i class="fad fa-search text-xs ml-1"></i></template> Rechercher
            </Button>
        </div>
    </div>
</template>

<script>
    import qs from "qs"
    import JetLabel from '@/Components/InputLabel.vue'
    import JetInput from '@/Components/TextInput.vue'
    import Multiselect from '@vueform/multiselect'
    import Button from '@/Components/PrimaryButton.vue'
    import InteractWithFilterMixins from "@/Mixins/InteractWithFilterMixins.vue";

    export default {
        components: {
            JetLabel,
            JetInput,
            Multiselect,
            Button
        },

        mixins: [InteractWithFilterMixins],

        data() {
            return {
                select: {
                }
            }
        },
        mounted() {
            this.fillSelectModel()
            if (window.location.search) {
                this.setFormFields()
            }
        },
        methods: {
            fillSelectModel() {
                for (const [key, value] of Object.entries(this.$page.props.queryBuilderProps.filters)) {
                    this.select[key] = value.config.mode === 'tags' ? [] : null
                }
            },
            setFormFields() {
                const params = qs.parse(window.location.search.substring(1))
                if (params.filter) {
                    for (const [key, value] of Object.entries(params.filter)) {
                        if (this.$page.props.queryBuilderProps.search[key]) {
                            this.$page.props.queryBuilderProps.search[key].value = value
                        }
                        if (this.$page.props.queryBuilderProps.filters[key]) {
                            let filterValue = ''
                            if (this.$page.props.queryBuilderProps.filters[key].config.mode === 'tags') {
                                filterValue = value.split(',')
                            } else {
                                filterValue =  value
                            }
                            this.select[key] = filterValue
                            this.$refs[key].textValue = filterValue
                            this.$page.props.queryBuilderProps.filters[key].value = filterValue
                        }
                    }
                }
            },
        }
    }
</script>
