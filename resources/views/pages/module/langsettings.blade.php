<div class="alert alert-info">
    <strong><i class="fa fa-info"></i> {{ __('Information') }}</strong><br />
    {{ __('This will allow you to display the module only if the page is in the selected language. It is useful if the module is displayed on all pages.') }}
</div>

{{ Form::hidden('posId', $position->id) }}
<div class="form-group">
    {{ Form::label('posLang', __('Lang'), ['class' => 'control-label']) }}
    {{ Form::select('posLang', $langs, $position->lang, ['class' => 'form-control']) }}
</div>