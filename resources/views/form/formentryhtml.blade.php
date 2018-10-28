<div class="form-group">

    @if(isset($title) && !empty($title))
        <label class="control-label" for="{{ $uid }}">{{ $title }}</label>
    @endif

    @if(isset($type))
        {!! $type->getHtml() !!}
    @else
        <div class="alert alert-danger">{{ __('Entry type doesn\'t exists ...') }}</div>
    @endif

    @if(isset($description) && !empty($description))
        <span class="help-block">{{ $description }}</span>
    @endif

</div>