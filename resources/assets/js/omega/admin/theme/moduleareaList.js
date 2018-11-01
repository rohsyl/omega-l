$(function(){
    var $btnDelete = $('.deleteModulearea');
    $btnDelete.click(function(){
        var $btn = $(this);
        omega.modal.confirm(__('Do you really want to delete this ?'), function(yes){
            if(yes){
                var parent = $btn.parent().parent();
                var url = $btn.attr('href');
                parent.css('background-color', '#d9534f');
                omega.ajax.query(url, {}, omega.ajax.GET, function(){
                    parent.remove();
                });
            }
        });
        return false;
    });
});