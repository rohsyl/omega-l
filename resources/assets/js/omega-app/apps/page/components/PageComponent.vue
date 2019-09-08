<template>
    <div class="component-item">
        <div class="component-item-top">
            <ul>
                <li>
                    <span :class="'component-item-bgcolor ' + component_background_class"
                          :style="component_background_style"></span>
                    {{ component.pluginMeta.title }}
                </li>
                <li v-if="component_is_hidden"><i class="fa fa-eye-slash"></i></li>
                <li v-if="component_is_wrapped"><i class="fa fa-arrows-h"></i></li>
                <li v-if="component_use_template"><i class="fa fa-exclamation-circle"></i></li>
                <li v-if="component_has_id"><i class="fa fa-hashtag" id="id-comp-'.$component['id'].'"></i>{{ component.args.settings.compId }}</li>
            </ul>
        </div>
        <div class="component-item-container">
            <div v-html="component.html"></div>
            <div class="component-item-actions">
                <a href="#" class="settingsComponent" @click="settings"><i class="fa fa-cog"></i></a>
                <a href="#" class="deleteComponent" @click="deleteComponent"><i class="fa fa-trash"></i></a>

                <a href="#" class="upupComponent" @click=""><i class="fa fa-angle-double-up"></i></a>
                <a href="#" class="upComponent" @click=""><i class="fa fa-angle-up"></i></a>
                <a href="#" class="downComponent" @click=""><i class="fa fa-angle-down"></i></a>
                <a href="#" class="downdownComponent" @click=""><i class="fa fa-angle-double-down"></i></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageComponent",
        props: {
            component: {
                required: true,
                type: Object
            }
        },
        computed: {
            /*html_compiled: function() {
                return Vue.compile(this.component.html).render
            },*/
            component_background_class: function () {
                if(typeof this.component.args.settings.bgColorType !== "undefined") {
                    if(this.component.args.settings.bgColorType === 'transparent') {
                        return 'transparent'
                    }
                }
                return ''
            },
            component_background_style: function () {
                if(typeof this.component.args.settings.bgColorType !== "undefined") {
                    if(typeof this.component.args.settings.bgColor !== "undefined" &&
                              this.component.args.settings.bgColorType !== 'transparent') {
                        return 'background-color: ' + this.component.args.settings.bgColor + ';'
                    }
                }
                return ''
            },
            component_is_hidden: function() {
                if(typeof this.component.args.settings.isHidden !== "undefined") {
                    return this.component.args.settings.isHidden
                }
                return false
            },
            component_is_wrapped: function() {
                if(typeof this.component.args.settings.isWrapped !== "undefined") {
                    return this.component.args.settings.isWrapped
                }
                return false
            },
            component_use_template: function() {
                if(typeof this.component.args.settings.pluginTemplate !== "undefined") {
                    return this.component.args.settings.pluginTemplate !== null
                }
                return false
            },
            component_has_id: function() {
                if(typeof this.component.args.settings.compId !== "undefined") {
                    return this.component.args.settings.compId !== ''
                }
                return false
            }
        },
        methods: {
            settings: function() {

            },
            deleteComponent: function() {

            }
        }
    }
</script>

<style scoped>
    .component-item-container {
        min-height: 190px;
    }
</style>