<template>
    <div class="card">
        {{ component.name }}
    </div>
</template>

<script>
    export default {
        name: "PageComponentCreate",
        props: {
            component: {
                required: false,
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>