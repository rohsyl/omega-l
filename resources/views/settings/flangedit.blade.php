<div class="form-horizontal">

    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('slug', __('Slug'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::text('slug', $lang->slug, ['class' => 'form-control input-md', 'placeholder' => 'Slug', 'disabled']) }}
            <span class="help-block">{{ __('Can\'t be changed') }}</span>
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::text('name', $lang->name, ['class' => 'form-control input-md', 'placeholder' => 'Name']) }}
            <span class="help-block">The langauge name like "Francais"</span>
        </div>
    </div>

    <!-- Multiple Checkboxes (inline) -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('enabled', 0) }}
                    {{ Form::checkbox('enabled', 1, $lang->isEnabled, ['id' => 'enabled']) }}
                    {{ __('Enable this language') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('flag', __('Flag'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::omMediaChooser('flag', __('Flag'), $lang->fkMediaFlag, ['allowedMedia' => ['picture']]) }}
        </div>
    </div>
</div>