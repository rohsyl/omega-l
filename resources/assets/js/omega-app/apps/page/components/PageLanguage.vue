<template>
    <div class="form-horizontal">

        <div class="form-group">
            <label for="lang" class="control-label col-sm-3">{{ $t('language') }}</label>
            <div class="col-sm-5">
                <select id="lang" v-model="page.lang" class="form-control">
                    <option :value="null">{{ $t('none') }}</option>
                    <option v-for="language in languages" :value="language.slug">{{ language.name}}</option>
                </select>
                <span class="form-text text-muted">
                    {{ $t('label.language_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label>{{ $t('label.corresponding_page') }} :</label>
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i></strong> {{ $t('label.corresponding_page_help') }}
            </div>
            <table class="table table-condensed">
                <tr>
                    <th>{{ $t('languages') }}</th>
                    <th>{{ $t('page') }}</th>
                    <th></th>
                </tr>
                <tr class="row-plangs" v-for="language in languages_without_selected">
                    <td><label :for="'label_' + language.slug">{{ language.name }}</label></td>
                    <td>
                        <select :id="'label_' + language.slug" v-model="page.corresponding_pages[language.slug]" class="form-control">
                            <option :value="null"
                                    :selected="page.corresponding_pages[language.slug] === null">{{ $t('label.none')}}</option>
                            <option v-for="page_ in page.corresponding_parents[language.slug]"
                                    :value="page_.id"
                                    :selected="page.corresponding_pages[language.slug] === page_.id">{{ page_.name }}</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageLanguage",
        props: {
            page: {
                required: true,
                type: Object
            },
            languages: {
                required: true,
                type: Array
            }
        },
        computed: {
            languages_without_selected() {
                let self = this;
                return this.languages.filter(function(u) {
                    return u.slug !== self.page.lang
                })
            }
        },
        methods: {
            
        },
        mounted() {

        }
    }
</script>
