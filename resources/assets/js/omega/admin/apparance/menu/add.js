$(function(){
    function serialize(ol) {
        var data;
        step = function(level)
        {
            var array = [ ],
                items = level.children('li');
            items.each(function()
            {
                var li   = $(this),
                    item = $.extend({}, li.find('a.edit').first().data()),
                    sub  = li.children('ol');
                if (sub.length) {
                    item.children = step(sub);
                }
                array.push(item);
            });
            return array;
        };
        data = step(ol);
        return data;
    }
    $('#add').click(function(){
        var menu_name = $('#menu-name').val();
        var menu_description = $('#menu-description').val();
        var menu_secugrp = $('#menu-groupsecu').val();
        var menu_json = serialize($('#nestable > ol'));
        menu_json = String(JSON.stringify(menu_json));
        var isMain = $('#isMain').is(':checked');
        var langs = $('#langs').val();

        var url = omega.mvc.url('apparence', 'menuaddpost');
        var args = {
            name : menu_name,
            description : menu_description,
            json : menu_json,
            groupsecu : menu_secugrp,
            isMain : isMain,
            langs: langs
        };
        omega.ajax.query(url, args, omega.ajax.POST, function(data){
            var id = data;
            console.log("Response: " + data);
            if(id != false) {
                var url = omega.mvc.url('apparence', 'menuedit', {id: id});
                omega.location.load(url);
            }
        }, function(err){
            console.log(err);
            omega.notice.error(undefined, err);
        });
        return false;
    });
});