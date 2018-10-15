$(function(){
    var $btnSort = $('#sortPages');
    var $tableContainer = $('#tableContainer');
    $btnSort.click(function sort(){
        var html = '<p>' +
            '<div class="alert alert-info">'+__("Drag the different items up or down below to set how they should be arranged.") + '</div>' +
            '</p>' +
            '<table class="sortable table">';

        $('#tableContainer').find('tr.row-page').each(function(i){
            var pid = $(this).data('idpage');
            var pname = $(this).data('title');
            html += '<tr style="cusror:grab;" data-idpage="'+pid+'">' +
                '<td>' +
                pname +
                '</td>' +
                '</tr>';
        });
        html += '</table>';
        var mid = omega.modal.open(__('Sort'), html);

        $('td, th', '.sortable').each(function () {
            var cell = $(this);
            cell.width(cell.width());
            cell.css('background-color', '#ffffff');
        });
        $( '.sortable tbody' ).sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
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
            placeholder: 'sortable-placeholder',
            update: function( event, ui ) {
                var array = [];
                $('.sortable > tbody  > tr').each(function(i) {
                    var idPage = $(this).data('idpage');
                    array.push({order: i, id: idPage});
                });
                var url = omega.mvc.url('page', 'sort');
                var args = { order: array };
                omega.ajax.query(url, args, 'POST', function(){
                    updateTable();
                    $.growl.notice({title: __('Success'), message:__('Order updated')});
                });
            }
        }).disableSelection();
    });

    function updateTable()
    {
        var url = !$tableContainer.data('lang-enabled') ? route('admin.pages.index.table') : route('admin.pages.index.table', {lang: $tableContainer.data('lang-current')});
        omega.ajax.loadHtml($tableContainer, url.url());
    }
    updateTable();
});