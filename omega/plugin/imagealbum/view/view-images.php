<?php
    use Omega\Library\Entity\Media;
?>
<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li><a href="<?php echo $this->getAdminLink('albums', array('id' => $section[SEC_ID])) ?>"><?php echo $section[SEC_NAME_S] ?></a></li>
    <li>Edit images of album : <?php echo $album[ALB_NAME] ?></li>
</ol>
<table class="table" id="album-image-list">
    <tr>
        <th>Thumbnail</th>
        <th>Name</th>
        <th>
            <span style="float:right">
                <a class="btn btn-xs btn-primary" id="btnAddImages">Add images</a>
                <a class="btn btn-xs btn-default" id="btnSort">Sort</a>
                <a class="btn btn-xs btn-default" style="display:none" id="btnCancelSort">Cancel sorting</a>
            </span>
        </th>
    </tr>
    <?php foreach($images as $image) : ?>
        <tr data-id="<?php echo $image[IMG_ID] ?>">
            <td>
                <?php
                $media = new Media($image[IMG_MEDIA]);
                ?>
                <img src="<?php echo $media->GetThumbnail(100, 50) ?>" />
            </td>
            <td>
                <?php echo $media->name ?>
            </td>
            <td>
                <span style="float:right">
                    <a href="#" class="btnRemoveImage" data-id="<?php echo $image[IMG_ID] ?>">Remove</a>
                </span>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($images) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no images. <a href="<?php echo $this->getAdminLink('addAlbum') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>

<script>
    $(function(){
        var $body = $('body');
        var idAlbum = <?php echo $album[ALB_ID] ?>;
        var $btnAddImages =  $('#btnAddImages');
        var cBtnSort = '#btnSort';
        var $btnSort = $(cBtnSort);
        var cBtnCancelSort = '#btnCancelSort';
        var $btnCancelSort = $(cBtnCancelSort);
        var cBtnRemoveImage = '.btnRemoveImage';
        var cAlbumTable = '#album-image-list';
        var $albumTable = $(cAlbumTable);
        var sortMode = false;
        var beforeSortTable;

        $btnAddImages.rsMediaChooser({
            multiple: true,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function (data) {
                // has selected more than one media
                if($.isArray(data))
                {
                    for(var i = 0; i < data.length; i++)
                    {
                        addMedia(data[i]);
                    }
                }
                else
                {
                    addMedia(data);
                }
            }
        });

        $body.delegate( cBtnSort, 'click', function() {
            sortMode = !sortMode;
            var $this = $(this);
            if(sortMode) {
                $btnCancelSort.show();
                $this.text('Click to save this order');
                $this.addClass('btn-warning');
                $this.removeClass('btn-default');

                beforeSortTable = '';
                $albumTable.find('tr').not(':first').each(function(){
                    beforeSortTable += this.outerHTML;
                });

                $albumTable.css('cursor', 'move');
                $('td, th', cAlbumTable).each(function () {
                    var cell = $(this);
                    cell.width(cell.width());
                    cell.css('background-color', '#ffffff');
                });
                $albumTable.find('tbody').sortable({
                    containerSelector: 'table',
                    itemPath: '> tbody',
                    itemSelector: 'tr',
                    start: function(e, ui){
                        ui.placeholder.height(ui.item.height() + 10);
                    },
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
                    }
                }).disableSelection();
            }
            else{
                $this.text('Saving...');
                $this.removeClass('btn-warning');
                $this.addClass('btn-info');
                $btnCancelSort.hide();
                $albumTable.find('tbody').sortable("disable");
                $albumTable.css('cursor', 'default');

                var array = new Array();
                $albumTable.find('tr').each(function(i) {
                    if(i > 0){
                        var id = $(this).data('id');
                        array.push({order: i, id: id});
                    }
                });
                var url = omega.plugin.mvc.url('imagealbum', 'saveImagesOrder');
                var args = { orders: array };
                omega.ajax.query(url, args, 'POST', function(data){
                    if(data.success == true){
                        $this.text('Order saved !');
                        $this.removeClass('btn-info');
                        $this.addClass('btn-success');
                        setTimeout(function(){
                            $this.text('Sort');
                            $this.removeClass('btn-success');
                            $this.addClass('btn-default');
                        }, 1000);
                    }
                    else{
                        omega.notice.error("Error while saving order...");
                    }
                }, function(){
                    omega.notice.error("Error while saving order...");
                }, {dataType : 'json'});
            }

        });

        $body.delegate( cBtnCancelSort, 'click', function() {
            var $this = $(this);
           if(sortMode){
               $albumTable.find('tbody').sortable("cancel").disableSelection();
               $albumTable.css('cursor', 'default');
               $this.text('Cancelling...');
               $btnSort.text('Sort');
               if($btnSort.hasClass('btn-warning')) $btnSort.removeClass('btn-warning');
               if($btnSort.hasClass('btn-info')) $btnSort.removeClass('btn-info');
               $btnSort.addClass('btn-default');
               $albumTable.find('tr').not(':first').each(function(){
                   $(this).remove();
               });
               $albumTable.append(beforeSortTable);
               setTimeout(function(){
                   $this.hide();
                   $this.text('Cancel sort');
                   beforeSortTable = undefined;
                   sortMode = false;
               }, 500);
           }
        });

        $body.delegate( cBtnRemoveImage, 'click', function() {
            var $this = $(this);
            omega.modal.confirm('Are you sure ?', function(yes){
                if(yes){
                    var id = $this.data('id');
                    var $row = $this.parent().parent().parent();
                    var url = omega.plugin.mvc.url('imagealbum', 'deleteImage');
                    var data = {
                        'id' : id
                    };
                    $row.css('background-color', 'red');
                    omega.ajax.query(url, data, omega.ajax.POST, function(){
                        $row.remove();
                    });
                }
            });
        });

        function addMedia(media){
            // save in database
            var url = omega.plugin.mvc.url('imagealbum', 'addImages');
            var data = {
                'album' : idAlbum,
                'image' : media.id,
                'order' : countImages() + 1
            };
            omega.ajax.query(url, data, omega.ajax.POST);

            // display in page
            var name;
            if(media.title != null && media.title != '')
            {
                name = media.title+' ('+media.name+')';
            }
            else
            {
                name = media.name;
            }
            var html = '<tr>' +
                '<td><i class="'+media.icon+' fa-3x"></i></td> ' +
                '<td>'+name+'</td>' +
                '<td><span style="float:right"> ' +
                '<a href="#" class="btnRemoveImage" data-id="'+media.id+'">Remove</a>' +
                '</span></td>' +
                '</tr>';
            $albumTable.append(html);
        }

        function countImages(){
            // remove one for the table header
            return $albumTable.find('tr').length - 1;
        }
    });
</script>