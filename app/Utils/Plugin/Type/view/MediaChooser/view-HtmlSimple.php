<?php
use Omega\Library\Entity\Media;
use Omega\Library\Entity\VideoExternal;


$id = isset($value) ? $value : null;
$media = new Media($id);
$name = $media->name;
$title = $media->title;
$description = $media->description;
$allowedType = json_encode($param['type']);
?>

<div class="media <?php echo $uid ?>-media">
    <?php if($param['preview']) : ?>
    <div class="media-left media-middle" id="<?php echo $uid ?>-media-preview">
        <?php switch($media->getType()) :
            case Media::T_PICTURE:
                echo '<img class="media-object" src="'.$media->GetThumbnail(120, 85).'" alt="Thumbnail" width="120px"/>';
                break;
            case Media::T_FOLDER:
                echo '<i class="media-object fa fa-3x fa-folder"></i>';
                break;
            case Media::T_MUSIC:
                echo '<i class="media-object fa fa-3x fa-music"></i>';
                break;
            case Media::T_VIDEO:
                echo '<i class="media-object fa fa-3x fa-video"></i>';
                break;
            case Media::T_DOCUMENT:
            case Media::T_OTHER:
                echo '<i class="media-object fa fa-3x fa-file"></i>';
                break;
            case Media::T_VIDEO_EXT:
                $media = new VideoExternal($id);
                $thumbnail = $media->getVideoThumbnail();
                if(!empty($thumbnail))
                    echo '<img class="media-object" src="'.$thumbnail.'" alt="Thumbnail" width="120px"/>';
                else
                    echo '<span class="media-object">No thumbnail</span>';
                break;
        endswitch ?>
    </div>
    <?php endif ?>
    <div class="media-body">
        <h4 class="media-heading" id="<?php echo $uid ?>-media-name">
            <?php echo isset($title) && !empty($title) ? $title : $name ?>
        </h4>

        <div id="<?php echo $uid ?>-media-description">
        <?php if(isset($description) && !empty($description)): ?>
            <p><?php echo $description ?></p>
        <?php endif ?>
        </div>

        <button class="btn btn-default btn-sm" id="<?php echo $uid ?>-chooser">Choose</button>
        <button class="btn btn-danger btn-sm" id="<?php echo $uid ?>-deleter">Delete</button>
        <input value="<?php echo $id ?>" id="<?php echo $uid ?>-media-id" name="<?php echo $uid ?>-media-id" type="hidden">
    </div>
</div>
<script>
    $(function() {
        $("#<?php echo $uid ?>-chooser").rsMediaChooser({
            multiple: false,
            allowedMedia: <?php echo $allowedType ?>,
            doneFunction: function (data) {
                var t = data.type;
                var title = data.title;
                var name = data.name;
                var description = data.description;
                console.log(title);
                $("#<?php echo $uid ?>-media-id").val(data.id);
                $("#<?php echo $uid ?>-media-name").html(title !== undefined && title !== '' && title != null ? title : name);

                $("#<?php echo $uid ?>-media-description").empty();
                if(description !== undefined && description !== '' && description != null){
                    $("#<?php echo $uid ?>-media-description").html('<p>' + description + '</p>');
                }


                <?php if($param['preview']) : ?>
                    var html;
                    if(t === "picture")
                        html = '<i class="media-object fa fa-3x fa-picture-o"></i>';
                    else if(t === "folder")
                        html = '<i class="media-object fa fa-3x fa-folder"></i>';
                    else if(t === "music")
                        html = '<i class="media-object fa fa-3x fa-music"></i>';
                    else if(t === "video")
                        html = '<i class="media-object fa fa-3x fa-video"></i>';
                    else if(t == "video_ext")
                        html = '<i class="media-object fa fa-3x fa-play"></i>';
                    else
                        html = '<i class="media-object fa fa-3x fa-file"></i>';
                    $("#<?php echo $uid ?>-media-preview").html(html);
                <?php endif ?>
                }
            });
        $("#<?php echo $uid ?>-deleter").click(function(){
            var $id = $("#<?php echo $uid ?>-media-id");
            if($id.val() !== "" || $id.val() != null){
                $("#<?php echo $uid ?>-media-name").empty();
                $("#<?php echo $uid ?>-media-preview").empty();
                $id.val("null");
            }
            return false;
        });
    });
</script>
<style>

    .<?php echo $uid ?>-media .media-object{
        min-width: 120px;
        text-align: center;
    }
</style>