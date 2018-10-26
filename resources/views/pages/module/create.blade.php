<div class="form-horizontal form-add-module ">
    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-6">
            {{ Form::text('name', null, ['class' => 'form-control name', 'placeholder' => __('Name')]) }}
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        {{ Form::label('plugin', __('Plugin'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-6">
            {{ Form::select('plugin', $plugins, null, ['class' => 'form-control plugin']) }}
        </div>
    </div>
</div>
