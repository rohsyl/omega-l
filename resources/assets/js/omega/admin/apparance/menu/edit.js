$(function(){
    function _serialize(ol) {
        var data;
        step  = function(level)
        {
            var array = [ ],
                items = level.children('li');
            items.each(function() {

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

    var $btnSave = $('#edit');
    var $selectLang = $('#langs');

    $btnSave.click(function(){
        var name = $('#name').val();
        var description = $('#description').val();
        var membergroup = $('#membergroup').val();
        var json = _serialize($('#nestable > ol'));
        var menu_id = $('#nestable').data('menu-id');
        var isMain = $('#isMain').is(':checked') ? 1 : 0;
        json = String(JSON.stringify(json));
        var lang = $('#lang').val();

        var url = route('menu.update', {id : menu_id});
        var args = {
            name : name,
            description : description,
            json : json,
            membergroup : membergroup,
            isMain : isMain,
            lang: lang
        };
        omega.ajax.query(url, args, omega.ajax.POST, function(data){
            if(data.success){
                omega.notice.success(undefined, __('Menu updated'));
            }
            else
                omega.notice.error(undefined, __('Error while saving menu'));
        }, function(err){
            omega.notice.error(undefined, err);
        }, {dataType: 'json'});
        return false;
    });

    $selectLang.change(function () {
        loadPages();
    });
    loadPages();
    function loadPages(){
        var menu_id = $('#nestable').data('menu-id');
        var langs = $('#lang').val();
        var url = route('menu.edit.pages', {id: menu_id, lang: langs});
        omega.ajax.query(url, {}, omega.ajax.GET, function(html){
            $('#list-pages').empty().html(html);
        });
    }
});