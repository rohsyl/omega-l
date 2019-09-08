<template>
    <li :class="classActive">
        <a @click="click" href="#">
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
            click: function (e) {
                e.preventDefault();
                this.$emit('click', this.id)
            }
        }
    }
</script>

<style scoped>

</style>