$(function(){
    var $body = $('body');
    var pageId = $('.page-edit-form').data('page-id');
    var loading = '<p class="text-center"><img src="'+omega.abspath+'../img/loading.gif" alt="Loading ..." /></p>';

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
});