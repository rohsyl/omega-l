
$(function(){
    var pageId = $('.page-edit-form').data('page-id');
    var $body = $('body');
    var $btnAddModule = $('#add-content-module');
    var $btnAddComponent = $('#add-page-module');
    var $componentContainer = $('#component-container');
    var $inputTab = $('#tab');
    var componentItemClass = '.component-item';
    var $modulesContainer = $('#modules-container');
    var loading = '<p class="text-center"><img src="'+omega.abspath+'../img/loading.gif" alt="Loading ..." /></p>';

    // When tab is switched save the selected tab in an input
    // So when the user click on the save button, he is redirected
    // back to the right tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $inputTab.val($(e.target).attr('href').substring(1));
    });

    // Open a modale to create a new module
    $btnAddModule.click(function(){

        var url = route('admin.pages.getCreateFormForModule', { pageId : pageId });
        omega.ajax.query(url, {}, "GET", function(data){
            var idm = omega.modal.open(__("Create a module"), data, __("Create"), function(){
                var name = $('.form-add-module .name').val();
                var plugin = $('.form-add-module .plugin').val();
                url = route('admin.pages.createModule');
                var args = {
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
        var url = route('admin.pages.getEditFormForModule', { moduleId : id, pageId : pageId });
        omega.ajax.query(url, {}, 'GET', function(data){
            var mid = omega.modal.open('Edit module', '<form id="formEditModule">'+data+'</form>', 'Save', function(){
                var $form = $('#formEditModule');
                url = route('admin.pages.saveModule', {moduleId : id});
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
                var url = route('admin.pages.deleteComponent', {id: id});
                omega.ajax.query(url, {}, 'GET', function () {
                    loadModuleList();
                    loadModuleareas();
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


    // Set on all page
    $body.delegate( ".setOnAllPages", "click", function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $parent = $this.parent();

        var is = $this.data('is');

        console.log(is);

        if(is === 1)
        {

            $this.find('span').addClass('fa-spin');

            var posId = $this.data('positionid');
            url = route('admin.pages.ma.setonallpages', { id : posId, set : 0, pageId : pageId });
            omega.ajax.query(url.url(), {}, omega.ajax.POST, function(){
                $this.find('span').removeClass('glyphicon-star fa-spin');
                $this.find('span').addClass('glyphicon-star-empty');
                $this.data('is', 0);
            }, function(){
                alert(__('Ajax error while deleting module in area'));
            }, {dataType: 'json'});
        }
        else
        {
            $this.find('span').addClass('fa-spin');

            var posId = $this.data('positionid');
            url = route('admin.pages.ma.setonallpages', { id : posId, set : 1, pageId : 'null' });
            omega.ajax.query(url.url(), {}, omega.ajax.POST, function(){
                $this.find('span').removeClass('glyphicon-star-empty fa-spin');
                $this.find('span').addClass('glyphicon-star');
                $this.data('is', 1);
            }, function(){
                alert(__('Ajax error while deleting module in area'));
            }, {dataType: 'json'});
        }

        return false;
    });

    // Delete position
    $body.delegate( ".deletePosition", "click", function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $parent = $this.parent();
        var positionid = $this.data('positionid');
        var url = route('admin.pages.ma.delete', { id : positionid });
        omega.ajax.query(url, {}, "POST", function(){
            $parent.remove();
        }, function(){
            alert(__('Ajax error while deleting module in area'));
        }, {dataType: 'json'});
        return false;
    });

    // Add position
    $body.delegate( ".module-area-add", "click", function(e) {

        var moduleArea = $(this).parents('.module-area').data('areaname');
        var url = route('admin.pages.ma.plugins', { pageId : pageId });
        omega.ajax.query(url, {}, "GET", function(data){
            var html = '<p id="title">'+__('Select a plugin') + ' :</p>' +
                '<div class="list-group">';
            $.each(data.plugins, function(){

                html += '<a href="#" class="list-group-item plugin-item"\
                            data-type="plugin"\
							data-pluginid="'+this.id+'"\
							data-toggle="tooltip"\
							data-placement="right">'+this.name+'</a>';
            });
            html += '<\div>';
            var idm = omega.modal.open(__('Select a plugin'), html);

            var $plugin = $('.plugin-item');
            $plugin.click(function(){
                var id = $(this).data('pluginid');
                var text = $(this).html();

                var url = route('admin.pages.ma.plugins.modules', { pluginId : id, pageId : pageId });
                omega.ajax.query(url, {}, 'GET', function(data){

                    var html = '<p id="title">' + __('Select a module of') + ' ' + text +' :</p>' +
                        '<div class="list-group">';
                    $.each(data.modules, function(){

                        html += '\
								<a href="#" class="list-group-item module-item"\
									data-type="module"\
									data-moduleid="'+this.id+'"\
									data-toggle="tooltip"\
									data-placement="right">\
										'+this.name+'\
								</a>';
                    });
                    html += '<\div>';
                    omega.modal.updateBody(idm, html);

                    var $module = $('.module-item');

                    $module.click(function(){
                        var id = $(this).data('moduleid');
                        var url = route('admin.pages.ma.add', {pageId : pageId});
                        var args = {
                            areaName : moduleArea,
                            moduleId : id
                        };
                        omega.modal.updateBody(idm, loading);
                        omega.ajax.query(url, args, omega.ajax.POST, function(data){
                            loadModuleareas();
                            omega.modal.hide(idm);
                        }, function () {
                            alert(__('Ajax error while adding module in area'));
                        });
                        return false;
                    });

                }, function () {
                    alert(__('Ajax error while getting modules'));
                }, { dataType: 'json' });
            });
        }, function () {
            alert(__('Ajax error while getting plugins'));
        }, { dataType: 'json' });
    });

    loadModuleareas();
    function loadModuleareas(){

        url = route('admin.pages.moduleareaList',  { id : pageId });
        $('#modulearea-list').html(loading);
        omega.ajax.query(url, {}, 'GET', function(data){
            $('#modulearea-list').html(data);
            createSortable();
        });



    }

    function createSortable(){
        $('.sortable').each(function () {
            Sortable.create(this, {
                group: 'sort',
                animation: 150,
                handle: '.glyphicon-move',
                ghostClass: 'sortable-ghost',  // Class name for the drop placeholder
                draggable: '.sortable-item',  // Specifies which items inside the element should be draggable
                // Changed sorting within list
                onEnd: function (/**Event*/evt) {
                    var array = [];
                    $('.sortable > .sortable-item').each(function(i) {
                        var posId = $(this).data('positionid');
                        var modulearea = $(this).closest('.module-area').data('areaname');
                        array.push({order: i, positionid: posId, modulearea: modulearea});
                    });
                    var url = route('admin.pages.ma.setorder');
                    var args = { order : JSON.stringify(array) };
                    omega.ajax.query(url, args, "POST", function(){
                        omega.notice.success(__('Order updated'));
                    });
                },


            });
        });
    }


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