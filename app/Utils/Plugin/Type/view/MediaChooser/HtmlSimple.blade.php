@php
$id = isset($value) && !empty($value) ? $value : null;
$media = new \Omega\Models\Media();
$name = '';
$title = '';
$description = '';
if(isset($id) && !empty($id))
{
    $media = \Omega\Utils\Entity\Media::Get($id);
    if(isset($media)){
        $name = $media->name;
        $title = $media->title;
        $description = $media->description;
    }
}
$allowedType = json_encode($param['type']);
@endphp

<div class="media {{ $uid }}-media">
    @if($param['preview'])
    <div class="media-left media-middle" id="{{ $uid }}-media-preview">
        @if(isset($media))
            @if($media->getType() == \Omega\Utils\Entity\Media::T_PICTURE)
                <img class="media-object" src=" {{ $media->getThumbnail(120, 85) }}" alt="Thumbnail" width="120px"/>
            @elseif($media->getType() == \Omega\Utils\Entity\Media::T_FOLDER)
                <i class="media-object fa fa-3x fa-folder"></i>
            @elseif($media->getType() == \Omega\Utils\Entity\Media::T_MUSIC)
                <i class="media-object fa fa-3x fa-music"></i>
            @elseif($media->getType() == \Omega\Utils\Entity\Media::T_VIDEO)
                <i class="media-object fa fa-3x fa-video"></i>
            @elseif($media->getType() == \Omega\Utils\Entity\Media::T_DOCUMENT || $media->getType() == \Omega\Utils\Entity\Media::T_OTHER)
                <i class="media-object fa fa-3x fa-file"></i>
            @elseif($media->getType() == \Omega\Utils\Entity\Media::T_VIDEO_EXT)
                @php
                    $thumbnail = '';
                    if(isset($id)){
                        $media = new \Omega\Utils\Entity\VideoExternal($media);
                        $thumbnail = $media->getVideoThumbnail();
                    }
                @endphp
                @if(!empty($thumbnail))
                    <img class="media-object" src="{{ $thumbnail }}" alt="Thumbnail" width="120px"/>
                @else
                    <span class="media-object">No thumbnail</span>
                @endif
            @endif
        @else
            <i class="media-object fa fa-3x fa-file"></i>
        @endif
    </div>
    @endif
    <div class="media-body">
        <h4 class="media-heading" id="{{ $uid }}-media-name">
            {{ isset($title) && !empty($title) ? $title : $name }}
        </h4>

        <div id="{{ $uid }}-media-description">
        @if(isset($description) && !empty($description))
            <p>{{ $description }}</p>
        @endif
        </div>

        <button class="btn btn-default btn-sm" id="{{ $uid }}-chooser">Choose</button>
        <button class="btn btn-danger btn-sm" id="{{ $uid }}-deleter">Delete</button>
        <input value="{{ $id }}" id="{{ $uid }}-media-id" name="{{ $uid }}-media-id" type="hidden">
    </div>
</div>
<script>
    $(function() {
        $("#{{ $uid }}-chooser").rsMediaChooser({
            multiple: false,
            allowedMedia: {!! $allowedType !!},
            doneFunction: function (data) {
                var t = data.type;
                var title = data.title;
                var name = data.name;
                var description = data.description;
                console.log(title);
                $("#{{ $uid }}-media-id").val(data.id);
                $("#{{ $uid }}-media-name").html(title !== undefined && title !== '' && title != null ? title : name);

                $("#{{ $uid }}-media-description").empty();
                if(description !== undefined && description !== '' && description != null){
                    $("#{{ $uid }}-media-description").html('<p>' + description + '</p>');
                }


                @if($param['preview'])
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
                    $("#{{ $uid }}-media-preview").html(html);
                @endif
                }
            });
        $("#{{ $uid }}-deleter").click(function(){
            var $id = $("#{{ $uid }}-media-id");
            if($id.val() !== "" || $id.val() != null){
                $("#{{ $uid }}-media-name").empty();
                $("#{{ $uid }}-media-preview").empty();
                $id.val("null");
            }
            return false;
        });
    });
</script>
<style>

    .{{ $uid }}-media .media-object{
        min-width: 120px;
        text-align: center;
    }
</style>