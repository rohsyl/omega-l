<template>
    <div class="toolbar">
        <a @click="" class="btn btn-primary btn-tooltip" :title="$t('action.save')" name="getEditPageForm">
            <span class="glyphicon glyphicon-floppy-disk"></span> <span class="hidden-xs">{{ $t('action.save') }}</span>
        </a>

        <a @click="" class="btn btn-info btn-tooltip" target="_blank" :title="$t('action.view')">
            <span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs hidden-sm">{{ $t('action.view') }}</span>
        </a>

        <!--@if(has_right('page_disable'))
        @if(!$page->isEnabled)-->
        <a @click="" :title="$t('action.enable')" class="btn btn-success btn-tooltip">
            <span class="glyphicon glyphicon-ok"></span> <span class="hidden-xs hidden-sm">{{ $t('action.enable') }}</span>
        </a>
        <!--@else-->
        <a @click="" :title="$t('action.disable')" class="btn btn-warning btn-tooltip">
            <span class="glyphicon glyphicon-remove"></span> <span class="hidden-xs hidden-sm">{{ $t('action.disable') }}</span>
        </a>
        <!--@endif
        @endif-->

        <!--@if(has_right('page_delete'))-->
        <a @click
           :title="$t('action.delete')"
           class="btn btn-danger btn-tooltip">
            <span class="glyphicon glyphicon-trash"></span> <span class="hidden-xs hidden-sm">{{ $t('action.delete') }}</span>
        </a>
        <!--@endif-->
    </div>
</template>

<script>
    export default {
        name: "Toolbar"
    }
</script>

<style scoped>

</style>