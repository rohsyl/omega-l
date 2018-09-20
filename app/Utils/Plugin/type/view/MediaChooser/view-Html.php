<?php
    use Omega\Library\Entity\Media;
    use Omega\Library\Entity\VideoExternal;


    $allowedType = json_encode($param['type']);

    $medias = array();
    foreach($values as $val){
        $mediaId = $val['id'];
        $media = new Media($mediaId);
        $mediaItem = array(
            'id' => $mediaId,
            'name' => $media->name,
            'title' => $media->title,
            'description' => $media->description,
            'type' => $media->getType(),
        );
        if($media->getType() == Media::T_PICTURE){
            $mediaItem['thumbnail'] = $media->GetThumbnail(120, 68);
        }
        if($media->type == Media::EXTERNAL_VIDEO){
            $media = new VideoExternal($mediaId);
            $mediaItem['thumbnail'] = $media->getVideoThumbnail();
        }
        $medias[] = $mediaItem;
    }
    $jsonMedia = json_encode($medias);
?>
<div>
    <button class="btn btn-primary" id="<?php echo $uid ?>-media-chooser"><i class="fa fa-plus"></i> Add media(s)</button>
    <div id="<?php echo $uid ?>-media-container">
    </div>
</div>
<script language="JavaScript">
    $(function(){
        var hasPreview = <?php echo $param['preview'] ? 'true' : 'false' ?>;
        var medias = <?php echo $jsonMedia ?>;
        var idDeleter = '<?php echo $uid ?>-deleter';
        var $body = $( "body" );
        var $btnAdd = $('#<?php echo $uid ?>-media-chooser');
        var $mediaContainer = $('#<?php echo $uid ?>-media-container');

        initList(medias);

        $body.delegate( '.'+idDeleter, 'click', function() {
            var $this = $(this);
            var modalId = omega.modal.confirm('Do you really want to delete this ?',function(yes){
                if(yes){
                    var i = $this.data('index');
                    $('input[name="<?php echo $uid ?>-media-delete[' + i + ']').val(1);
                    $this.parent().parent().hide();
                    omega.modal.hide(modalId);
                }
            });
            return false;
        });


        $btnAdd.rsMediaChooser({
            multiple: true,
            allowedMedia: <?php echo $allowedType ?>,
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

        function initList(medias){
            for(var i = 0; i < medias.length; i++){
                addMedia(medias[i]);
            }
        }

        function addMedia(media) {
            var i = countItem();
            var type = media.type;
            var title = media.title;
            var name = media.name;
            var description = media.description;
            var headingText = title !== undefined && title !== '' && title != null ? title : name;

            var logo = '';
            if(media.type === 'video_ext'){
                logo = '<i class="fa fa-play"></i> ';
            }

            var html = '<div class="media <?php echo $uid ?>-media">';
            html += getPreview(media);
            html += '<div class="media-body">';
            html += '<button class="btn btn-danger btn-sm <?php echo $uid ?>-deleter" data-index="'+i+'">Delete</button>';
            html += '<h4 class="media-heading" id="<?php echo $uid ?>-media-name">' + logo + headingText + '</h4>';
            html += '<div id="<?php echo $uid ?>-media-description">';
            if(description !== undefined && description !== '' && description != null) {
                html += '<p>' + description + '</p>';
            }
            html += '</div>'; // end.media-description


            html += '<input type="hidden" name="<?php echo $uid ?>-media-id['+i+']" value="'+media.id+'">' +
                '<input type="hidden" name="<?php echo $uid ?>-media-type['+i+']" value="'+type+'">' +
                '<input type="hidden" name="<?php echo $uid ?>-media-order['+i+']" value="'+i+'">' +
                '<input type="hidden" name="<?php echo $uid ?>-media-delete['+i+']" value="0">';

            html += '</div>'; // end.media-body
            html += '</div>'; // end.media

            $mediaContainer.append(html);
        }


        function getPreview(media){
            var html = '<div class="media-left media-middle" id="<?php echo $uid ?>-media-preview">';
            if(hasPreview){

                if(media.type === 'picture'){
                    if(media.thumbnail !== undefined) {
                        html += '<img class="media-object" src="' + media.thumbnail + '" alt="Thumbnail" width="120px"/>';
                    }
                    else {
                        html += '<i class="media-object fa fa-3x fa-picture-o"></i>';
                    }
                }
                else if(media.type === 'folder'){
                    html += '<i class="media-object fa fa-3x fa-folder"></i>';
                }
                else if(media.type === 'music'){
                    html += '<i class="media-object fa fa-3x fa-music"></i>';
                }
                else if(media.type === 'video'){
                    html += '<i class="media-object fa fa-3x fa-file-video-o"></i>';
                }
                else if(media.type === 'video_ext'){
                    if(media.thumbnail !== undefined){
                        html += '<img class="media-object" src="'+media.thumbnail+'" alt="Thumbnail" width="120px"/>';
                    }
                    else{
                        html += '<i class="media-object fa fa-3x fa-play"></i>';
                    }
                }
                else{
                    html += '<i class="media-object fa fa-3x fa-file"></i>';
                }
            }
            html += '</div>';
            return html;
        }

        function countItem()
        {
            return $mediaContainer.children().length;
        }

        $('.<?php echo $uid ?>-media', '#<?php echo $uid ?>-media-container').each(function () {
            var cell = $(this);
            //cell.width(cell.width());
            cell.css('background-color', '#ffffff');
        });
        $( '#<?php echo $uid ?>-media-container' ).sortable({
            itemPath: '>',
            itemSelector: '.<?php echo $uid ?>-media',
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
            placeholder: '<?php echo $uid ?>-sortable-placeholder',
            update: function( event, ui ) {
                var i = 0;
                $('#<?php echo $uid ?>-media-container .<?php echo $uid ?>-media').each(function(i) {
                    var $inputOrder = $(this).find('input[name^="<?php echo $uid ?>-media-order"]');
                    $inputOrder.val(i);
                    i++;
                });
            }
        }).disableSelection();
    });
</script>
<style>
    #<?php echo $uid ?>-media-container{
        margin-top: 15px;
    }
    #<?php echo $uid ?>-media-container .<?php echo $uid ?>-media{
        border-bottom: 1px solid #ddd;
        padding : 10px;
        cursor : move;
        margin-top : 0;
    }

    #<?php echo $uid ?>-media-container .<?php echo $uid ?>-media .media-body{
        padding-top : 10px;
    }

    #<?php echo $uid ?>-media-container .media-object{
        min-width: 120px;
        text-align: center;
    }
    #<?php echo $uid ?>-media-container .<?php echo $uid ?>-deleter{
        float:right;
    }

    .<?php echo $uid ?>-sortable-placeholder{
        height : 100px;
        background-color : #9bc373;
    }
</style>