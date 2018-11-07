@if(isset($file))
    <div class="embed-responsive embed-responsive-4by3">
    <object data="{{ asset($file->path) }}" type="application/pdf" width="100%" height="{{ isset($height) && !empty($height) ? $height : '800' }}px">
        <p>It appears you don't have a PDF plugin for this browser.
            No biggie... you can <a href="{{ asset($file->path) }}">click here to
                download the PDF file.</a></p>
    </object>
    </div>
    <p>{{ __('Download the') }} <a href="{{ asset($file->path) }}">{{ __('file') }}</a>.</p>
@endif