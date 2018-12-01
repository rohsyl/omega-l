
@if(!$isWritable)
    <div class="alert alert-danger">
        <strong>File upload is not available ...</strong><br />
        {{ __('The directory') }} <code>{{ media_path() }}</code> {{ __('is not writable. Please check the permissions...') }}
    </div>
@else

    <script src="{{ asset('js/omega/admin/medias/uploader.js') }}" defer></script>

        <div class="row">
            <div class="{{ $isModal ? 'col-md-12' : 'col-md-9' }}">
                <div class="alert alert-info">
                    Max upload file size is {{ $maxUploadFileSize }}.
                </div>
                <div id="container">
                    <input type="hidden" id="upload-url" value="{{ route('media.uploadhandler') }}" />
                    <input type="hidden" id="upload-parent" value="{{ $parent }}" />
                    <p>Select files from your computer</p>
                    <a id="browse" href="javascript:" class="btn btn-primary">{{ __('Browse...') }}</a>
                    <a id="start-upload" href="javascript:" class="btn btn-warning">{{ __('Start Upload') }}</a>
                    <div id="dropzone" class="dropzone">
                        or drag and drop them here
                    </div>
                </div>
                <br />
                <table id="filelist" class="table table-striped table-hover">

                </table>
            </div>
            @if(!$isModal)
            <div class="col-md-3">
                <div class="alert alert-info">
                    {{ __('Files that are uploaded from this page will be automatically placed at the root.') }}
                </div>
            </div>
            @endif
        </div>

@endif