@extends('layouts.app')


@push('scripts')
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
@endpush

@section('content')
    @if(!$isAjax)
    <h1 class="page-header">{{ __('Media Library') }}</h1>
    @endif

    <div id="rsExplorer{{ $isAjax ? 'Ajax' : '' }}-{{ $uid }}">
    </div>
    <div id="uploader-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="model-title" aria-hidden="true">
        <div class="modal-dialog" style="width:900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="model-title">File Uploader</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" id="uploader-modal-close" class="btn btn-default">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection