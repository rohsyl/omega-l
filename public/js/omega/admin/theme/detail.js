$(function(){
    var theme = $('#detail-theme').data('theme');
    var $btnAddModulearea = $('#btnAddModulearea');
    var $container = $('#moduleareaList');

    $btnAddModulearea.click(function(){
        omega.ajax.query(route('theme.detail.ma.add', {name: theme}), {}, omega.ajax.GET, function(html){
            var modalId = omega.modal.open(__("Add new Modulearea"), html, __("Create"), function(){
                omega.modal.hide(modalId);
                var modulearea = $('#modulearea').val();
                omega.ajax.query(route('theme.detail.ma.create', {name: theme}), {modulearea : modulearea}, omega.ajax.POST, function(json){
                    if(json.success){
                        load_ma_list();
                    }
                    else{
                        omega.message.error(__("Error"), __("Error while adding modulearea"))
                    }
                }, undefined, {dataType: 'json'});
            })
        });
        return false;
    });
    load_ma_list();
    function load_ma_list(){
        omega.ajax.query(route('theme.detail.ma.list', {name: theme}), {}, omega.ajax.GET, function(html){
            $container.html(html);
        });
    }
});