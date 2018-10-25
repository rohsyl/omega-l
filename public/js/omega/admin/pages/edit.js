
$(function(){
    var pageId = $('.page-edit-form').data('page-id');
    var $body = $('body');
    var $btnAddModule = $('#add-content-module');
    var $btnAddComponent = $('#add-page-module');
    var $componentContainer = $('#component-container');
    var $inputTab = $('#tab');
    var componentItemClass = '.component-item';
    var $modulesContainer = $('#modules-container');

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $inputTab.val($(e.target).attr('href').substring(1));
    });

    $btnAddModule.click(function(){

        var url = omega.mvc.url('page', 'getCreateFormForModule');
        var args = { pid : pageId };
        omega.ajax.query(url, args, "GET", function(data){
            var idm = omega.modal.open(__("Create a module"), data, __("Create"), function(){
                var name = $('#name').val();
                var plugin = $('#plugin').val();
                url = omega.mvc.url('page', 'createModule');
                args = {
                    pageId : pageId,
                    pluginId : plugin,
                    name : name
                };
                omega.ajax.query(url, args, "POST", function(){
                    loadModuleList();
                    omega.modal.hide(idm);
                });
            });
        });
        return false;
    });

    $btnAddComponent.click(function(){

        var url = omega.mvc.url('page', 'getCreateFormForComponent');
        var args = { pid : pageId };
        omega.ajax.query(url, args, omega.ajax.GET, function(data){
            var idm = omega.modal.open(__("Insert a component"), data, __("Insert"), function(){
                var $componentActive= $('.component-container.active');
                if($componentActive.length == 1) {
                    var pluginId = $componentActive.data('pluginid');
                    url = omega.mvc.url('page', 'createComponent');
                    args = { pageId : pageId, pluginId : pluginId };
                    omega.ajax.query(url, args, omega.ajax.GET, function(data){
                        if(data.result !== false){
                            var compId = data.result;
                            url = omega.mvc.url('page', 'getComponentForm');
                            args = { id : compId };
                            omega.ajax.query(url, args, omega.ajax.GET, function(data){
                                $componentContainer.append(data);
                                hideOrShowOrderingButtons();
                            });
                        }
                        else{
                            omega.notice.error('Error while creating component');
                        }
                    }, undefined, {dataType: 'json'});
                    omega.modal.hide(idm);
                }
            });
        });
        return false;
    });

    $body.delegate( ".editModule", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'getEditFormForModule');
        var args = { moduleId : id, pageId : pageId };
        omega.ajax.query(url, args, 'GET', function(data){
            var mid = omega.modal.open('Edit module', '<form id="formEditModule">'+data+'</form>', 'Save', function(){
                var $form = $('#formEditModule');
                url = omega.mvc.url('page', 'saveModule', {moduleId : id});
                args = omega.ajax._serializeForm($form);
                omega.ajax.query(url, args, 'POST', function(){
                    omega.modal.hide(mid);
                });
            }, 'modal-lg');
        });
        return false;
    });

    $body.delegate( ".deleteModule", "click", function() {
        var id = $(this).data('id');
        omega.modal.confirm(__('Do you really want to delete this ?'), function(yes){
            if(yes){
                var url = omega.mvc.url('page', 'deleteComponent');
                var args = {cid: id};
                omega.ajax.query(url, args, 'GET', function () {
                    url = omega.mvc.url('page', 'moduleList');
                    args = {id: pageId};
                    omega.ajax.query(url, args, 'GET', function (data) {
                        $modulesContainer.html(data);
                    });
                });
            }
        });
    });

    $body.delegate( ".deleteComponent", "click", function() {
        var $this = $(this);
        omega.modal.confirm(__('Do you really want to delete this ?'), function(yes){
            if(yes){
                var id = $this.data('id');
                var url = omega.mvc.url('page', 'deleteComponent');
                var args = {cid: id};
                omega.ajax.query(url, args, 'GET', function () {
                    url = omega.mvc.url('page', 'componentList');
                    args = {id: pageId};
                    omega.ajax.query(url, args, 'GET', function (data) {
                        $componentContainer.html(data);
                    });
                });
            }
        });
        return false;
    });

    $body.delegate( ".settingsComponent", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'getFormComponentSettings');
        var args = { compId : id };
        omega.ajax.query(url, args, 'GET', function(data){
            var mid = omega.modal.open(__("Edit component's settings"), '<form id="formEditSettings">'+data+'</form>', __('Save'), function(){
                var $form = $('#formEditSettings');
                url = omega.mvc.url('page', 'saveSettings', { compId : id });
                args = omega.ajax._serializeForm($form);
                omega.ajax.query(url, args, 'POST', function(response){
                    var jResponse = JSON.parse(response);
                    $('#hidden-comp-' + id).parent().remove();
                    if(jResponse.args.settings.isHidden) {
                        $('#component-' + id + ' .component-item-top ul').append('<li><i class="fa fa-eye-slash" id="hidden-comp-'+id+'"></i></li>');
                    }
                    $('#fullwidth-comp-' + id).parent().remove();
                    if(!jResponse.args.settings.isWrapped) {
                        $('#component-' + id + ' .component-item-top ul').append('<li><i class="fa fa-arrows-h" id="fullwidth-comp-'+id+'"></i></li>');
                    }
                    $('#template-comp-' + id).parent().remove();
                    if(jResponse.args.settings.pluginTemplate != 'null') {
                        $('#component-' + id + ' .component-item-top ul').append('<li><i class="fa fa-exclamation-circle" id="template-comp-'+id+'"></i></li>');
                    }
                    if(jResponse.args.settings.bgColorType == 'transparent'){
                        $('#bg-comp-' + id).addClass('transparent');
                    }
                    else{
                        var $item = $('#bg-comp-' + id);
                        if($item.hasClass('transparent')) $item.removeClass('transparent');
                        $item.css('background-color', jResponse.args.settings.bgColor);
                    }
                    $('#id-comp-' + id).parent().remove();
                    if(jResponse.args.settings.compId != ''){
                        $('#component-' + id + ' .component-item-top ul').append(
                            '<li><i class="fa fa-hashtag" id="id-comp-'+id+'"></i>'+jResponse.args.settings.compId+'</li>');
                    }
                    omega.modal.hide(mid);
                });
            }, 'modal-lg');
        });
        return false;
    });

    $body.delegate( ".upComponent", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'orderComponent');
        var args = { compId : id, position: 'up' };
        omega.ajax.query(url, args, 'GET', function(data) {
            url = omega.mvc.url('page', 'componentList');
            args = {id: pageId};
            omega.ajax.query(url, args, 'GET', function (data) {
                $componentContainer.html(data);
                omega.notice.success(undefined, __('Order updated'))
            });
        });
        return false;
    });

    $body.delegate( ".upupComponent", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'orderComponent');
        var args = { compId : id, position: 'upper' };
        omega.ajax.query(url, args, 'GET', function(data) {
            url = omega.mvc.url('page', 'componentList');
            args = {id: pageId};
            omega.ajax.query(url, args, 'GET', function (data) {
                $componentContainer.html(data);
                omega.notice.success(undefined, __('Order updated'))
            });
        });
        return false;
    });

    $body.delegate( ".downdownComponent", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'orderComponent');
        var args = { compId : id, position: 'downer' };
        omega.ajax.query(url, args, 'GET', function(data) {
            url = omega.mvc.url('page', 'componentList');
            args = {id: pageId};
            omega.ajax.query(url, args, 'GET', function (data) {
                $componentContainer.html(data);
                omega.notice.success(undefined, __('Order updated'))
            });
        });
        return false;
    });

    $body.delegate( ".downComponent", "click", function() {
        var id = $(this).data('id');
        var url = omega.mvc.url('page', 'orderComponent');
        var args = { compId : id, position: 'down' };
        omega.ajax.query(url, args, 'GET', function(data) {
            url = omega.mvc.url('page', 'componentList');
            args = {id: pageId};
            omega.ajax.query(url, args, 'GET', function (data) {
                $componentContainer.html(data);
                omega.notice.success(undefined, __('Order updated'))
            });
        });
        return false;
    });



    function hideOrShowOrderingButtons(){
        var count = $componentContainer.children(componentItemClass).length;
        $componentContainer.children(componentItemClass).each(function(i) {
            var $item = $(this);
            if (i > 0) {
                $item.find('.upupComponent').removeClass('hidden');
                $item.find('.upComponent').removeClass('hidden');
            }
            if(i < count - 1){
                $item.find('.downComponent').removeClass('hidden');
                $item.find('.downdownComponent').removeClass('hidden');
            }
        });
    }

    loadModuleList();
    function loadModuleList(){
        url = route('admin.pages.moduleList', { id : pageId });
        omega.ajax.query(url, {}, "GET", function(data){
            $modulesContainer.html(data);
        });
    }
});