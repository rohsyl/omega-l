<div class="form-horizontal">

    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('slug', __('Slug'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::text('slug', '', ['class' => 'form-control input-md', 'placeholder' => 'Slug']) }}
            <span class="help-block">{{ __('The language abbrevation. Exemple : fr for Francais') }}</span>
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::text('name', '', ['class' => 'form-control input-md', 'placeholder' => 'Name']) }}
            <span class="help-block">The langauge name like "Francais"</span>
        </div>
    </div>

    <!-- Multiple Checkboxes (inline) -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('enabled', 0) }}
                    {{ Form::checkbox('enabled', 1, 1) }}
                    {{ __('Enable this language"') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('flag', __('Flag'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-7">
            {{ Form::omMediaChooser('flag', __('Flag'), null) }}
        </div>
    </div>
</div>