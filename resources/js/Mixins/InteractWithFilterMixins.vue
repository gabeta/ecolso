
<script>
    import qs from "qs";
    import pickBy from "lodash-es/pickBy";

    export default {
        methods: {
            search(withEvent = true) {
                console.log('search')
                let query = qs.stringify(this.queryBuilderString(), {
                    filter(prefix, value) {
                        if (typeof value === "object" && value !== null) {
                            return pickBy(value);
                        }
                        return value;
                    },

                    skipNulls: true,
                    strictNullHandling: true,
                });

                if (withEvent) {
                    this.$emit('searchLaunched')
                }

                this.$inertia.get(location.pathname + `?${query}`);
            },
            queryBuilderString() {
                console.log('lol')
                console.log(this.$page.props.queryBuilderProps.search)
                return this.getFilterForQuery(
                    this.$page.props.queryBuilderProps.search || {},
                    this.$page.props.queryBuilderProps.filters || {}
                )
            },
            getFilterForQuery(search, filters) {
                let filtersWithValue = {
                    filter: {}
                };

                const filtersAndSearch = Object.assign({}, filters, search);

                for (const [key, filterOrSearch] of Object.entries(filtersAndSearch)) {
                    if (filterOrSearch.value) {
                        filtersWithValue.filter[key] = Array.isArray(filterOrSearch.value) ? filterOrSearch.value.join(',') : filterOrSearch.value;
                    }
                }

                return filtersWithValue;
            },
            changeSearchValue(key, value) {
                this.$page.props.queryBuilderProps.search[key].value = value;
            },
            changeFilterValue(key) {
                this.$page.props.queryBuilderProps.filters[key].value = this.$refs[key][0].textValue;
            },
        },
    }
</script>
