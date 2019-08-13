<template>
    <div class="tab-pane page-tab" :class="classActive">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "TabPane",
        props: {
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
    }
</script>

<style scoped>

</style>