<template>
    <div class="loader-container">
        <p class="text-center text-muted"><i :class="fa"></i></p>
    </div>
</template>

<script>
    export default {
        name: "Loading",
        props: {
            size: {
                required: false,
                type: Number
            }
        },
        computed: {
            fa: function() {
                let size = typeof this.size === 'undefined' ? 2 : this.size;
                return 'fa fa-spinner fa-' + size + 'x fa-spin'
            }
        }
    }
</script>

<style scoped>
    .loader-container {
        margin: 0 auto;
        margin-top : 150px;
    }
</style>