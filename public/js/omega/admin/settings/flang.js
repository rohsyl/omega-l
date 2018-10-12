$(function(){
    var btnAddLang = '#langf-add';
    var btnEditLanf = '#langf-edit';
    var btnDeleteLanf = '#langf-delete';
    var $containerLangf = $('#flangtab');
    var $chkLang = $('#flang_enable');
    var $listLang = $('#flang_default');



    $('body').delegate(btnAddLang, 'click', function() {
        var url = route('admin.settings.flang.langfadd');
        omega.ajax.query(url, {}, omega.ajax.GET, function(html){
            var mid = omega.modal.open(__('Add front-end language'), html, __('Add'), function(){
                var args = {
                    slug: $('#slug').val(),
                    name: $('#name').val(),
                    enabled: $('#enabled').is(':checked') ? 1 : 0,
                    fkMedia: $('#flag').val()
                };
                var url = route('admin.settings.flang.langfcreate');
                omega.ajax.query(url, args, omega.ajax.POST, function(json){
                    if(json.success){
                        omega.notice.success(__('Success'), json.message);
                        omega.modal.hide(mid);
                        loadTable();
                    }
                    else{
                        omega.notice.error(__('Error'), json.message);
                    }
                }, undefined, { dataType: 'json' });
            });
        }, undefined, { dataType: 'html' });
    });

    $('body').delegate(btnEditLanf, 'click', function() {
        var slug = $(this).data('slug');
        var url = route('admin.settings.flang.langfedit', {slug: slug});
        omega.ajax.query(url, {}, omega.ajax.GET, function(html){
            var mid = omega.modal.open(__('Edit front-end language'), html, __('Save'), function(){
                var args = {
                    name: $('#name').val(),
                    enabled: $('#enabled').is(':checked') ? 1 : 0,
                    fkMedia: $('#flag').val()
                };
                var url = route('admin.settings.flang.langfupdate', {slug: slug});
                omega.ajax.query(url, args, omega.ajax.POST, function(json){
                    if(json.success){
                        omega.notice.success(__('Success'), json.message);
                        omega.modal.hide(mid);
                        loadTable();
                    }
                    else{
                        omega.notice.error(__('Error'), json.message);
                    }
                }, undefined, { dataType: 'json' });
            });
        }, undefined, { dataType: 'html' });
    });

    $('body').delegate(btnDeleteLanf, 'click', function() {
        var slug = $(this).data('slug');
        var url = route('admin.settings.flang.langfdelete', {slug: slug})

        omega.modal.confirm(__('Do you really want to delete this ?'), function(yes){
            if(yes){
                omega.ajax.query(url, {}, omega.ajax.GET, function(json){
                    if(json.success){
                        omega.notice.success(__('Success'), json.message);
                        loadTable();
                    }
                    else{
                        omega.notice.error(__('Error'), json.message);
                    }
                }, undefined, { dataType: 'json' });
            }
        });
    });

    showHideFlang();
    $chkLang.change(function(){
        showHideFlang();
    });

    function showHideFlang(){
        if($chkLang.is(':checked')){
            $listLang.prop('disabled', false);
            $containerLangf.show();
        }
        else{
            $listLang.prop('disabled', true);
            $containerLangf.hide();
        }

    }

    function loadTable(){
        var url = route('admin.settings.flang.table');
        omega.ajax.query(url, {}, omega.ajax.GET, function (html) {
            $containerLangf.empty().html(html);
        }, undefined, { dataType: 'html' });
    }
    loadTable();
});