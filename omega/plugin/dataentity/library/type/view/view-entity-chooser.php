<div id="container-<?php echo $uid ?>">
    <p>
        <button class="btn btn-primary" id="button-<?php echo $uid ?>">Choose</button>
    </p>
    <table class="table table-hover" id="table-<?php echo $uid ?>">
        <?php foreach($objdata as $o): ?>
            <tr id="row-<?php echo $uid ?>-<?php echo $o['id'] ?>" data-id="<?php echo $o['id'] ?>" data-view="<?php echo $o['view'] ?>">
                <td><?php echo $o['id'] ?></td>
                <td><strong><?php echo $o['entityTitle'] ?></strong></td>
                <td><?php echo $o['title'] ?></td>
                <td>
                    <span class="action-img-page-list">
                        <a href="#" class="setview-<?php echo $uid ?>" data-id="<?php echo $o['id'] ?>"><i class="fa fa-cog"></i> View</a>
                        |
                        <a href="#" class="remove-<?php echo $uid ?> text-danger" data-id="<?php echo $o['id'] ?>"><i class="fa fa-trash"></i> Remove</a>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="hidden" name="<?php echo $uid ?>" id="<?php echo $uid ?>" value="<?php echo $value ?>" />
</div>
<script lang="javascript">
    $(function(){
        var $body = $('body');
        var $button = $('#button-<?php echo $uid ?>');
        var $table = $('#table-<?php echo $uid ?>');
        var $input = $('#<?php echo $uid ?>');
        var cDataInstance = '.entity-item-data.selected';
        var cSetView = '.setview-<?php echo $uid ?>';
        var cDelete = '.remove-<?php echo $uid ?>';
        var cViewList = '#entity-views';

        function setValueFromTable(){
            var values = {};
            var i = 0;
            $table.find('tr').each(function(){
                var id = $(this).data('id');
                var view = $(this).data('view');
                values[i] = {
                    id: id,
                    view: view
                };
                i++;
            });
            var json = JSON.stringify(values);
            $input.val(encodeURIComponent(json));
        }
        function renderRow(row){
            var html = '<tr id="row-<?php echo $uid ?>-'+row.id+'" data-id="'+row.id+'" data-view="'+row.view+'">' +
                '<td>' + row.id + '</td>' +
                '<td><strong>' + row.entityTitle + '</strong></td>' +
                '<td>' + row.title + '</td>' +
                '<td>' +
                    '<span class="action-img-page-list">' +
                        '<a href="#" class="setview-<?php echo $uid ?>" data-id="' + row.id + '"><i class="fa fa-cog"></i> View</a>' +
                        ' | ' +
                        '<a href="#" class="remove-<?php echo $uid ?> text-danger" data-id="' + row.id + '"><i class="fa fa-trash"></i> Remove</a>' +
                    '</span>\n' +
                '</td>' +
                '</tr>';
            $table.append(html);
        }

        $button.click(function(e){
            e.preventDefault();
            var url = omega.plugin.mvc.url('dataentity', 'browser');
            omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                var mId = omega.modal.open(__('Choose some entity instances'), html, __('Choose'), function(){

                    var data = [];
                    $(cDataInstance).each(function(){
                        data.push({
                            id : $(this).data('id'),
                            view: undefined,
                            entityTitle : $(this).data('entityTitle'),
                            title : $(this).find('.title').text()
                        });
                    });
                    omega.modal.hide(mId);

                    for(var row in data){
                        renderRow(data[row]);
                    }
                    setValueFromTable();
                });
            });
            return false;
        });

        $body.off('click', cDelete);
        $body.on('click', cDelete, function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var row = '#row-<?php echo $uid ?>-' + id;
            omega.modal.confirm(__('Do you really want to remove this item ?'), function(bol){
                if(bol){
                    $(row).remove();
                    setValueFromTable();
                }
            });
            return false;
        });

        $body.off('click', cSetView);
        $body.on('click', cSetView, function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var view = $('#row-<?php echo $uid ?>-'+id).data('view');

            var url = omega.plugin.mvc.url('dataentity', 'getViewsForEntityData', {dataId: id, viewId: view});
            omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                var mId = omega.modal.open(__('Configure View'), html, __('Save'), function(){
                    var $select = $(cViewList);
                    console.log($select.val());
                    $('#row-<?php echo $uid ?>-'+id).data('view', $select.val());
                    setValueFromTable();
                    omega.modal.hide(mId);
                });
            });

            return false;
        });

    });
</script>