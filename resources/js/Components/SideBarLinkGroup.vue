<template>
    <li class="px-3 py-2 rounded-sm mb-1 last:mb-0" :class="activeCondition && 'bg-gray-900'">
        <slot :handleClick="handleClick" :expanded="expanded" />
    </li>
</template>

<script>
    import { defineComponent, ref } from 'vue'

    export default defineComponent({
        props: {
            activeCondition: Boolean
        },

        setup (props) {
            const expanded = ref(props.activeCondition)

            const handleClick = () =>{
                expanded.value = !expanded.value
            }

            return {
                expanded,
                handleClick,
            }
        },
    })
</script>

<style scoped>

</style>
