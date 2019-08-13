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
            </NavTabs>
            <TabContent>
                <TabPane :active="tab_active(1)">
                    Hello
                </TabPane>
                <TabPane :active="tab_active(2)">
                    Yeeess
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

    export default {
        el: "#page-edit-app",

        components: {
            Loading, Toolbar, NavTabs, NavTab, TabPane, TabContent
        },

        data: {
            page_id: undefined,
            page: undefined,

            currentTab: 1
        },
        methods: {
            init: function() {
                this.get_page_id();
                this.load_page()
            },

            get_page_id: function() {
                const pageIdElement = document.getElementById( 'page_id' );
                const page_id = JSON.parse( pageIdElement.innerHTML );
                this.page_id = page_id
            },

            load_page: function() {
                let self = this;
                axios.get(route('api.pages.get', {'id' : this.page_id}))
                    .then(function (response) {
                        console.log(response.data);
                        self.page = response.data.data
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
            }
        },
        mounted: function() {
            this.init()
        }
    }
</script>

<style scoped>

</style>