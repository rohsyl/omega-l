<template>
    <div id="page-edit-app">
        <div v-if="typeof page === 'undefined'">
            <Loading :size="4"/>
        </div>
        <div v-else v-cloak>
            <div class="page-header">
                <h2>
                    <i class="fa fa-pencil-square-o"></i> {{ $t('page_edition')}}  - {{ page.name }}
                    <Toolbar />
                </h2>
            </div>
            <NavTabs>
                <NavTab :id="1" :active="tab_active(1)" @click="tab_click">{{ $t('content') }}</NavTab>
                <NavTab :id="2" :active="tab_active(2)" @click="tab_click">{{ $t('language') }}</NavTab>
                <NavTab :id="3" :active="tab_active(3)" @click="tab_click">{{ $t('parameters') }}</NavTab>
                <NavTab :id="4" :active="tab_active(4)" @click="tab_click">{{ $t('modulearea') }}</NavTab>
                <NavTab :id="5" :active="tab_active(5)" @click="tab_click">{{ $t('security') }}</NavTab>
            </NavTabs>
            <TabContent>
                <TabPane :active="tab_active(1)">

                    <div class="row">
                        <div class="col-md-10">
                            <draggable v-model="page.components" group="component">
                                <PageComponent v-for="component in page.components" :key="component.id" :component="component"></PageComponent>
                            </draggable>
                        </div>
                        <div class="col-md-2">
                            <h4>Available component</h4>
                            <p>Drag and drop component to the left to insert them in the page</p>
                            <draggable v-model="components_creatable" group="component">
                                <PageComponentCreate v-for="component in components_creatable" :component="component"></PageComponentCreate>
                            </draggable>
                        </div>
                    </div>

                </TabPane>
                <TabPane :active="tab_active(2)" v-if="page.config.languageEnabled">
                    <PageLanguage :page="page" :languages="languages"></PageLanguage>
                </TabPane>
                <TabPane :active="tab_active(3)">
                    <PageParameters :page="page"></PageParameters>
                </TabPane>
                <TabPane :active="tab_active(4)">
                    <PageModulearea :page="page"></PageModulearea>
                </TabPane>
                <TabPane :active="tab_active(5)">
                    Security
                </TabPane>
            </TabContent>
        </div>

    </div>
</template>

<script>
    import NavTabs from '../../../components/tabs/NavTabs'
    import NavTab from '../../../components/tabs/NavTab'
    import TabPane from '../../../components/tabs/TabPane'
    import TabContent from '../../../components/tabs/TabContent'
    import Loading from '../../../components/Loading'
    import Toolbar from './Toolbar'
    import PageComponent from "./PageComponent";
    import PageLanguage from "./PageLanguage";
    import PageParameters from "./PageParameters";
    import PageModulearea from "./PageModulearea";
    import PageComponentCreate from "./PageComponentCreate";
    import draggable from 'vuedraggable'

    export default {
        el: "#page-edit-app",

        components: {
            PageComponentCreate,
            PageModulearea,
            PageParameters,
            PageLanguage,
            PageComponent,
            Loading, Toolbar, NavTabs, NavTab, TabPane, TabContent, draggable
        },

        data: {
            page_id: undefined,
            page: undefined,
            languages: [],
            components_creatable: {},

            currentTab: 1
        },
        methods: {
            init: function() {
                let id = parseInt(window.location.hash.substr(1));
                if(!isNaN(id)) {
                    this.currentTab = id
                }

                this.get_page_id();
                this.load_page();
                this.load_languages();
                this.load_components_creatable()
            },

            get_page_id: function() {
                const pageIdElement = document.getElementById( 'page_id' );
                const page_id = JSON.parse( pageIdElement.innerHTML );
                this.page_id = page_id
            },

            load_languages: function() {
                let self = this;
                axios.get(route('api.languages.index'))
                    .then(function (response) {
                        self.languages = response.data.data
                    })
                    .catch(function (error) {
                        console.log(error.response.data)
                    });
            },

            load_page: function() {
                let self = this;
                axios.get(route('api.pages.edit', {'id' : this.page_id}))
                    .then(function (response) {
                        self.page = response.data.data
                    })
                    .catch(function (error) {
                        console.log(error.response.data)
                    });
            },

            load_components_creatable: function() {
                let self = this;
                axios.get(route('api.component.creatable'))
                    .then(function (response) {
                        self.components_creatable = response.data.data
                    })
                    .catch(function (error) {
                        console.log(error.response.data)
                    });
            },

            tab_active: function(id) {
                return this.currentTab === id
            },


            tab_active_class: function(id) {
                return this.tab_active(id) ? 'active' : ''
            },

            tab_click: function(id) {
                this.currentTab = id;
                console.log(id)
            },

            getIDfromURL: function(){
                console.log();
                return window.location.pathname.split('#')[1]
            }
        },
        mounted: function() {
            this.init()
        }
    }
</script>

<style scoped>

</style>