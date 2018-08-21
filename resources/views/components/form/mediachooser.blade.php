
{{-- $value : $id to a media --}}

@php
$isset = isset($value) && $value !== 0;
if($isset) {
    $media = \Omega\Media::Get($value);

    $name = $media->name;
    $id = $media->id;
}
@endphp
    <div class="input-group">
        <input value="@if($isset) {{ $name }} @endif()" id="{{ $name }}-name" name="{{ $name }}Name" placeholder="{{ $label }}" class="form-control input-md" type="text">
        <input value="@if($isset) {{ $id }} @endif()" id="{{ $name }}" name="{{ $name }}" type="hidden">
        <span id="{{ $name }}-chooser" class="input-group-addon btn btn-primary">{{ __('Choose') }}</span>
    </div>

<script>
    $(function(){
        $('#{{ $name }}-chooser').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'document'
            ],
            doneFunction: function(data){
                $('#{{ $name }}').val(data.id);
                $('#{{ $name }}-name').val(data.name);
            }
        });
    });
</script>