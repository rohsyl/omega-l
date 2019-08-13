<template>
    <li :class="classActive">
        <a @click="click">
            <slot></slot>
        </a>
    </li>
</template>

<script>
    export default {
        name: "NavTab",
        props: {
            id: {
                required: true,
                type: Number
            },
            active: {
                required: true,
                type: Boolean
            }
        },
        computed: {
            classActive: function() {
                return this.active ? 'active' : ''
            }
        },
        methods: {
            click: function () {
                this.$emit('click', this.id)
            }
        }
    }
</script>

<style scoped>

</style>