<template>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-3" for="name">{{ $t('label.name') }}</label>
            <div class="col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" v-model="page.showName" />
                    </span>
                    <input type="text" id="name" v-model="page.name" class="form-control" :placeholder="$t('label.title')" />
                </div>

                <span class="text-danger" role="alert">
                    <strong></strong>
                </span>
                <span class="help-block">
                    {{ $t('label.title_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="subtitle">{{ $t('label.subtitle') }}</label>
            <div class="col-sm-5">
                <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" v-model="page.showSubtitle" />
                </span>
                    <input type="text" id="subtitle" v-model="page.subtitle" class="form-control" :placeholder="$t('label.subtitle')" />
                </div>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.subtitle_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="slug">{{ $t('label.slug') }}</label>
            <div class="col-sm-5">
                <input type="text" id="slug" v-model="page.slug" class="form-control" :placeholder="$t('label.slug')" />
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.slug_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="parent">{{ $t('label.parent') }}</label>
            <div class="col-sm-5">
                <select id="parent" v-model="page.fkPageParent" class="form-control">
                    <option></option>
                </select>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.parent_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="model">{{ $t('label.model') }}</label>
            <div class="col-sm-5">
                <select id="model" v-model="page.model" class="form-control">
                    <option></option>
                </select>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.model_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="menu">{{ $t('label.menu') }}</label>
            <div class="col-sm-5">
                <select id="menu" v-model="page.menu" class="form-control">
                    <option></option>
                </select>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.menu_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="cssTheme">{{ $t('label.cssTheme') }}</label>
            <div class="col-sm-5">
                <select id="cssTheme" v-model="page.cssTheme" class="form-control">
                    <option></option>
                </select>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.cssTheme_help') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="keyword">{{ $t('label.keyword') }}</label>
            <div class="col-sm-5">
                <textarea if="keyword" class="form-control" v-model="page.keyWords"></textarea>
                <span class="text-danger" role="alert">
                </span>
                <span class="help-block">
                    {{ $t('label.keyword_help') }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageParameters",
        props: {
            page: {
                required: true,
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>