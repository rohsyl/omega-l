$(function(){
    var $btnSort = $('#sortPages');
    var $tableContainer = $('#tableContainer');
    $btnSort.click(function sort(){
        var html = '<p>' +
            '<div class="alert alert-info">'+__("Drag the different items up or down below to set how they should be arranged.") + '</div>' +
            '</p>' +
            '<ul class="sortable list-group">';

        $('#tableContainer').find('tr.row-page').each(function(i){
            var pid = $(this).data('idpage');
            var pname = $(this).data('title');
            html += '<li style="cusror:grab;" class="sortable-item list-group-item"  data-idpage="'+pid+'">' +
                pname +
                '</li>';
        });
        html += '</table>';
        var mid = omega.modal.open(__('Sort'), html);


        $('.sortable').each(function () {
            Sortable.create(this, {
                group: 'sort-pages',
                animation: 100,
                ghostClass: 'sortable-ghost',  // Class name for the drop placeholder
                // Changed sorting within list
                onEnd: function (/**Event*/evt) {

                    var array = [];
                    $('.sortable > .sortable-item').each(function(i) {
                        var idPage = $(this).data('idpage');
                        array.push({order: i, id: idPage});
                    });
                    var url = route('admin.pages.sort');
                    var args = { order: array };
                    omega.ajax.query(url, args, 'POST', function(){
                        updateTable();
                        omega.notice.success(__('Order updated'));
                    });
                },
            });
        });

    });


    function updateTable()
    {
        var currentPage = omega.getQueryStringParams('page');

        var args = {};
        if($tableContainer.data('lang-enabled')){
            args.lang = $tableContainer.data('lang-current');
        }

        if(typeof currentPage !== 'undefined'){
            args.page = currentPage;
        }

        var url = route('admin.pages.index.table', args);
        omega.ajax.loadHtml($tableContainer, url.url());
    }
    updateTable();



});