
<script>
    $(function(){

        $('#rsExplorer{{ $isAjax ? 'Ajax' : '' }}-{{ $uid }}').rsExplorer({
            rootId : {{ $rootId }},

            siteUrl: '{{ url('/') }}',
            uploaderUrl: '{{ route('media.uploader') }}',
            gifLoader: '{{ asset('img/loading-light.gif')  }}',
            inception: {{ $inception ? 'true' : 'false' }}
        });

        $('#uploader-modal-close').click(function () {
            $('#uploader-modal').modal('hide')
        });
    });
</script>