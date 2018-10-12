
{{-- $value : $id to a media --}}

@php
use Omega\Models\Media;

if(!isset($attributes['allowedMedia'])){
    $attributes['allowedMedia'] = ['folder', 'picture', 'video', 'document', 'music', 'video_ext'];
}

$isset = isset($value) && $value !== 0;
if($isset) {
    $media = Media::Get($value);

    $mediaName = $media->name;
    $mediaId = $media->id;
}
@endphp
    <div class="input-group">
        <input value="@if($isset) {{ $mediaName }} @endif" id="{{ $name }}-name" name="{{ $name }}Name" placeholder="{{ $label }}" class="form-control input-md" type="text">
        <input value="@if($isset) {{ $mediaId }} @endif" id="{{ $name }}" name="{{ $name }}" type="hidden">
        <span id="{{ $name }}-chooser" class="input-group-addon btn btn-primary">{{ __('Choose') }}</span>
    </div>

<script>
    $(function(){
        $('#{{ $name }}-chooser').rsMediaChooser({
            multiple: false,
            allowedMedia: {!! json_encode($attributes['allowedMedia']) !!},
            doneFunction: function(data){
                $('#{{ $name }}').val(data.id);
                $('#{{ $name }}-name').val(data.name);
            }
        });
    });
</script>