$(function(){
    var pageId = $('.page-edit-form').data('page-id');
    var loading = '<p class="text-center"><img src="'+omega.abspath+'../assets/img/loader.gif" alt="Loading ..." /></p>';
    $('td, th', '.sortable').each(function () {
        var cell = $(this);
        cell.width(cell.width());
        cell.css('background-color', '#ffffff');
    });
    $( '.sortable tbody' ).sortable({
        helper: function(e, tr)
        {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index)
            {
                // Set helper cell sizes to match the original sizes
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },
        update: function( event, ui ) {
            var array = [];
            $('.sortable > tbody  > tr').each(function(i) {
                var posId = $(this).data('positionid');
                array.push({order: i, positionid: posId});
            });
            var url = omega.mvc.url('modulearea', 'setOrder');
            var args = { order : JSON.stringify(array) };
            omega.ajax.query(url, args, "POST", function(){
                $.growl.notice({title: '', message: __('Order updated')});
            });
        }
    }).disableSelection();

    // Set on all page
    $( "body" ).delegate( ".setOnAllPages", "click", function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $parent = $this.parent().parent();

        var is = $this.data('is');

        if(is == 1)
        {
            var pageId = $(this).parents('.module-area').data('pageid');

            $parent.css('background-color', '#00ff00');
            $this.find('span').addClass('fa-spin');

            var positionid = $parent.data('positionid');
            var url = omega.mvc.url('modulearea', 'setOnAllPages');
            var args = { pageid : pageId, value : 0, positionid : positionid };
            omega.ajax.query(url, args, "GET", function(){
                $this.find('span').removeClass('glyphicon-star fa-spin');
                $this.find('span').addClass('glyphicon-star-empty');
                $parent.css('background-color', '#ffffff');
                $this.data('is', 0);
            }, function(){
                alert(__('Ajax error while deleting module in area'));
                $parent.css('background-color', '#ffffff');
            });
        }
        else
        {
            $parent.css('background-color', '#00ff00');
            $this.find('span').addClass('fa-spin');

            var positionid = $parent.data('positionid');
            var url = omega.mvc.url('modulearea', 'setOnAllPages');
            var args = { pageid : pageId, value : 1, positionid : positionid };
            omega.ajax.query(url, args, "GET", function(){
                $this.find('span').removeClass('glyphicon-star-empty fa-spin');
                $this.find('span').addClass('glyphicon-star');
                $parent.css('background-color', '#ffffff');
                $this.data('is', 1);
            }, function(){
                alert(__('Ajax error while deleting module in area'));
                $parent.css('background-color', '#ffffff');
            });
        }

    });

    // Delete position
    $( "body" ).delegate( ".deletePosition", "click", function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $parent = $this.parent().parent();

        $parent.css('background-color', '#ff0000');

        var positionid = $parent.data('positionid');
        var url = omega.mvc.url('modulearea', 'deletePosition');
        var args = { positionid : positionid };
        omega.ajax.query(url, args, "GET", function(){
            $parent.remove();
        }, function(){
            alert(__('Ajax error while deleting module in area'));
            $parent.css('background-color', '#ffffff');
        });
        return false;
    });

    // Add position
    $( "body" ).delegate( ".module-area span.glyphicon-plus", "click", function(e) {

        var moduleArea = $(this).parents('.module-area').data('areaname');
        var url = omega.mvc.url('modulearea', 'listplugin');
        var args = { pageId : pageId };
        omega.ajax.query(url, args, "GET", function(data){
            var html = '<p id="title">'+__('Select a plugin') + ' :</p>' +
                '<div class="list-group">';
            $.each(data.plugins, function(){

                html += '<a href="#" class="list-group-item plugin-item"\
                            data-type="plugin"\
							data-pluginid="'+this.id+'"\
							data-toggle="tooltip"\
							data-placement="right">'+this.plugName+'</a>';
            });
            html += '<\div>';
            var idm = omega.modal.open(__('Select a plugin'), html);

            var $plugin = $('.plugin-item');
            $plugin.click(function(){
                var id = $(this).data('pluginid');
                var text = $(this).html();

                var url = omega.mvc.url('modulearea', 'listmodulebyplugin');
                var args = { pluginid : id, pageId : pageId };
                omega.ajax.query(url, args, 'GET', function(data){

                    var html = '<p id="title">' + __('Select a module of') + ' ' + text +' :</p>' +
                        '<div class="list-group">';
                    $.each(data.modules, function(){

                        html += '\
								<a href="#" class="list-group-item module-item"\
									data-type="module"\
									data-moduleid="'+this.id+'"\
									data-toggle="tooltip"\
									data-placement="right">\
										'+this.moduleName+'\
								</a>';

                    });
                    html += '<\div>';
                    omega.modal.updateBody(idm, html);

                    var $module = $('.module-item');

                    $module.click(function(){
                        var id = $(this).data('moduleid');
                        var url = omega.mvc.url('modulearea', 'addPosition');
                        var args = {
                            areaname : moduleArea,
                            moduleid : id,
                            pageid : pageId
                        };
                        omega.modal.updateBody(idm, loading);
                        omega.ajax.query(url, args, 'GET', function(data){
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
        });
    }
});