$(function () {
    var $tablePlangs = $('#table-plangs');

    $tablePlangs.find('tr.row-plangs').each(function(){
        var idparent = $(this).data('idparent');
        var lang = $(this).data('lang');
        var pid = $(this).data('pid');
        loadPages(idparent, lang, pid);
    });

    function loadPages(idparent, lang, pid){
        var $select = $('#select-plangs-'+lang);
        var args = {
            pid: pid,
            lang: lang
        };
        if(idparent != null)
            args.idParent = idparent;

        var url = route('admin.pages.getbyparentandlang', args);
        omega.ajax.query(url, {}, omega.ajax.GET, function(json){
            $select.empty();
            addOption($select, null, 'Any');
            json.pages.forEach(function(page){
                addOption($select, page.id, page.name, json.selected == page.id);
            })
        }, undefined, {dataType: 'json'});
    }

    function addOption(select, value, text, selected){
        var sel = selected ? 'selected' : '';
        select.append('<option ' + sel + ' value="' + value + '">' + text + '</option>')
    }
});