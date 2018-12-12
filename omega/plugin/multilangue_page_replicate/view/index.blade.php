@extends('layouts.plugin')

@section('plugin_content')
    <div class="form-horizontal">

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="alert alert-info">
                    <strong><i class="fa fa-info"></i> {{ __('Informations') }}</strong><br />
                    {{ __('This tools allow you tu duplicate pages from a selected language to one or many destinations languages.') }}
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('source', __('Source language'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::select('source', $langselect, null, ['class' => 'form-control', 'id' => 'langSource']) }}
                <span class="help-text">
                    {{ __('Choose the language from which you want to duplicate content') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('source_pages', __('Source pages'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div id="pagesListContainer" style="height: 150px; overflow-y: scroll;">
                    <br />
                    <small class="text-muted">{{ __('You must choose a source language before...') }}</small>
                </div>
                <span class="help-text">
                    {{ __('Check pages that must be duplicated...') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('duplicate_components', __('Duplicate components'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('duplicate_components', 1, true, ['id' => 'duplicate_components']) }}
                        {{ __('Yes') }}
                    </label>
                </div>
                <span class="help-text">
                    {{ __('Does components inside each pages must be duplicated too ?') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('duplicate_modules', __('Duplicate modules'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('duplicate_modules', 1, true, ['id' => 'duplicate_modules']) }}
                        {{ __('Yes') }}
                    </label>
                </div>
                <span class="help-text">
                    {{ __('Does modules that are languages specific must be duplicated too ?') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('duplicate_pagechild', __('Duplicate page child'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('duplicate_pagechild', 1, true, ['id' => 'duplicate_pagechild']) }}
                        {{ __('Yes') }}
                    </label>
                </div>
                <span class="help-text">
                    {{ __('Does children of selected pages must be duplicated too ?') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('destination_langs', __('Destination languages'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div id="langsListContainer" style="height: 150px; overflow-y: scroll;">
                    <br />
                    <small class="text-muted">{{ __('You must choose a source language before...') }}</small>
                </div>
                <span class="help-text">
                    {{ __('Choose one or many destination languages') }}
                </span>
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <button id="duplicate" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing" class="btn btn-primary"><i class="fa fa-clone"></i> {{ __('Duplicate pages now') }}</button>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script language="JavaScript">
        $(function(){

            let checkallCheckbox = '#source_pages_checkall';
            let $langSource = $('#langSource');
            let $pageListContainer = $('#pagesListContainer');
            let $langListContainer = $('#langsListContainer');
            let $btnDuplicate = $('#duplicate');
            let $chkDuplicateComponents = $('#duplicate_components');
            let $chkDuplicateModules = $('#duplicate_modules');
            let $chkDuplicatePagechild = $('#duplicate_pagechild');

            $btnDuplicate.prop("disabled",true);

            $langSource.change(function () {
                let val = $(this).val();

                if(val === 'null'){
                    $btnDuplicate.prop("disabled",true);
                    $pageListContainer.empty();
                    $langListContainer.empty();
                    return;
                }

                loadPagesList(val);
                loadLangsList(val);

                $btnDuplicate.prop("disabled",false);
            });

            $btnDuplicate.click(function(e){
                let url = '{{ route_plugin('multilangue_page_replicate', 'duplicate') }}';

                var pages = $('input[name="source_pages[]"]:checked').map(function(){
                    return parseInt($(this).val());
                }).get();

                var langs = $('input[name="destination_langs[]"]:checked').map(function(){
                    return $(this).val();
                }).get();


                let data = {
                    pages: pages,
                    duplicate_components: $chkDuplicateComponents.is(':checked') ? 1 : 0,
                    duplicate_modules: $chkDuplicateModules.is(':checked') ? 1 : 0,
                    duplicate_pagechild: $chkDuplicatePagechild.is(':checked') ? 1 : 0,
                    langs: langs
                };

                $btnDuplicate.prop("disabled",true);
                $btnDuplicate.button('loading');
                omega.ajax.query(url, data, omega.ajax.POST, function(data){
                    $btnDuplicate.prop("disabled",false);
                    $btnDuplicate.button('reset');
                    if(data.success){
                        toastr.success('Done!');
                    }
                    else{
                        toastr.error('Error!');
                    }
                }, function(error){

                    $btnDuplicate.prop("disabled",false);
                    $btnDuplicate.button('reset');
                    console.log(error);
                    omega.notice.error(error.responseJSON.message);

                });
            });


            function loadPagesList(lang){
                let url = '{{ route_plugin('multilangue_page_replicate', 'pageList') }}';
                omega.ajax.query(url, {lang: lang}, omega.ajax.GET, function(data){
                    console.log(data.pages);

                    $pageListContainer.html(pages_toHtml(data.pages));
                    checkall_event();

                }, function(error){
                    $pageListContainer.html(error);
                });
            }

            function loadLangsList(lang){
                let url = '{{ route_plugin('multilangue_page_replicate', 'langList') }}';
                omega.ajax.query(url, {lang: lang}, omega.ajax.GET, function(data){
                    console.log(data.langs);

                    $langListContainer.html(langs_toHtml(data.langs));

                }, function(error){
                    $pageListContainer.html(error);
                });
            }



            function pages_toHtml(pages) {
                let html = '<table class="table table-condensed"> ' +
                    '<tr>\n' +
                    '<th width="25"><input type="checkbox" id="source_pages_checkall" value="0" /></th>' +
                    '<th>Name</th>\n' +
                    '</tr>';

                for (let i = 0; i < pages.length; i++) {
                    html += '<tr>' +
                        '<td><input type="checkbox" name="source_pages[]" value="' + pages[i].id + '" /></td>' +
                        '<td>' + pages[i].name + '</td>' +
                        '</tr>';
                }
                html += ' </table>';
                return html
            }

            function langs_toHtml(langs) {
                let html = '<table class="table table-condensed"> ' +
                    '<tr>\n' +
                    '<th width="25"></th>' +
                    '<th>Name</th>\n' +
                    '</tr>';

                for (let i = 0; i < langs.length; i++) {
                    html += '<tr>' +
                        '<td><input type="checkbox" name="destination_langs[]" value="' + langs[i].slug + '" /></td>' +
                        '<td>' + langs[i].name + '</td>' +
                        '</tr>';
                }
                html += ' </table>';
                return html
            }
            function checkall_event(){
                $(checkallCheckbox).change(function () {
                    let checked = $(this).is(':checked');
                    $("input[name='source_pages[]']").each(function () {
                        $(this).prop('checked', checked);
                    });
                });
            }
        });
    </script>
@endpush