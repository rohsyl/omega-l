<!-- Text input-->
<div class="form-group">
    {{ Form::label('compId', __('Component ID'), ['class' => 'control-label']) }}
    {{ Form::text('compId', isset($compId) ? $compId : '', ['class' => 'form-control', 'placeholder' => __('Component ID'), 'id' => 'compId' ]) }}
    <span class="help-block">{{ __('Set the #id of the component\'s section') }}</span>
</div>

<!-- Text input-->
<div class="form-group">
    {{ Form::label('compTitle', __('Component Title'), ['class' => 'control-label']) }}
    {{ Form::text('compTitle', isset($compTitle) ? $compTitle : '', ['class' => 'form-control', 'placeholder' => __('Component Title'), 'id' => 'compTitle' ]) }}
    <span class="help-block">{{ __('A title for the component') }}</span>
</div>


<!-- Select -->
<div class="form-group">
    {{ Form::label('compTemplate', __('Component\'s template'), ['class' => 'control-label']) }}
    {{ Form::select('compTemplate', $pluginTemplates, $pluginTemplate, ['class' => 'form-control', 'id' => 'compTemplate']) }}
    <span class="help-block">
        {{ __('Choose the template for this component') }}.

        @if(!isset($isPluginTemplateUpToDate))
            <a href="#" class="btn btn-xs btn-success" id="btn-check-compatibility" data-toggle="tooltip" data-placement="bottom" title="{{ __('Click to check if it is up to date') }}"><i class="fa fa-check"></i> {{ __('Up to date') }}</a>
        @else
            @if($isPluginTemplateUpToDate)
                <a href="#" class="btn btn-xs btn-success" id="btn-check-compatibility" data-toggle="tooltip" data-placement="bottom" title="{{ __('Click to check if it is up to date') }}"><i class="fa fa-check"></i> {{ __('Up to date') }}</a>
            @else
                <a href="#" class="btn btn-xs btn-warning" id="btn-check-compatibility" data-toggle="tooltip" data-placement="bottom" title="{{ __('Click to check if it is up to date') }}"><i class="fa fa-times"></i> {{ __('Is outdated and could cause errors') }}</a>
            @endif
        @endif
    </span>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
    {{ Form::label('is_hidden', __('Hide'), ['class' => 'control-label']) }}
    <div class="checkbox">
        <label class="radio-inline" for="is_hidden_chk">
            {{ Form::hidden('is_hidden', 0) }}
            {{ Form::checkbox('is_hidden', 1, $isHidden, ['id' => 'is_hidden_chk']) }}
            {{ __('Hide the component') }}
        </label>
    </div>
</div>


<div class="form-group">
    {{ Form::label('comp_width', __('Component width'), ['class' => 'control-label']) }}
    <div>
        <label class="radio-inline" for="comp_width-0">
            {{ Form::radio('comp_width', 'wrapped', $isWrapped, ['id' => 'comp_width-0']) }}
            {{ __('Wrapped') }}
        </label>
        <label class="radio-inline" for="comp_width-1">
            {{ Form::radio('comp_width', 'full-width', !$isWrapped, ['id' => 'comp_width-1']) }}
            {{ __('Full Width') }}
        </label>
    </div>
</div>

<!-- Multiple Radios -->
<div class="form-group">
    {{ Form::label('bgcolor', __('Background color'), ['class' => 'control-label']) }}
    <label class="control-label" for="bgcolor">Background color :</label>
    <div class="row">
        <div class="col-sm-3">
            <div class="radio">
                <label for="bgcolor-0">
                    {{ Form::radio('bgcolor', 'transparent', $bgColorType == 'transparent', ['id' => 'bgcolor-0']) }}
                    {{ __('Transparent') }}
                </label>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-3">
            <div class="radio">
                <label for="bgcolor-1">
                    {{ Form::radio('bgcolor', 'custom', $bgColorType == 'custom', ['id' => 'bgcolor-1']) }}
                    {{ __('Custom') }}
                </label>
            </div>
        </div>
        <div class="col-sm-4">
            <input type="color" name="customcolor" class="form-control" @if(isset($bgColor) && $bgColorType == 'custom') value="{{ $bgColor }}" @endif />
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-3">
            <div class="radio">
                <label for="bgcolor-2">
                    {{ Form::radio('bgcolor', 'theme', $bgColorType == 'theme', ['id' => 'bgcolor-2']) }}
                    {{ __('Theme') }}
                </label>
            </div>
        </div>
        <div class="col-sm-4">
            <select class="form-control" name="themecolor">
                <option value="transparent" @if($bgColor == 'transparent') checked @endif>{{ __('Choose a value') }}</option>
                @foreach($themeColors as $color)
                    @php $selected = (isset($bgColor) && $bgColorType == 'theme' && $bgColor == $color) ? 'selected' : ''; @endphp
                    <option {{ $selected }} value="{{ $color }}" style="background-color: {{ $color }}">{{ $color }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<script language="JavaScript">
    $(function(){
        $('#btn-check-compatibility').click(function(e){
            var $this = $(this);
            var url = route('admin.pages.isComponentsTemplateUpToDate');
            $this.removeClass('btn-success').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-spinner fa-spin"></i> Loading');
            omega.ajax.query(url, { componentsTemplateString : $('#compTemplate').val() }, 'POST', function(data){
                console.log(data);
                if(data.upToDate == null){
                    $this.addClass('btn-success').removeClass('btn-default').html('<i class="fa fa-check"></i> Up to date');
                }
                else{
                    if(data.upToDate){
                        $this.addClass('btn-success').removeClass('btn-default').html('<i class="fa fa-check"></i> Up to date');
                    }
                    else{
                        $this.addClass('btn-warning').removeClass('btn-default').html('<i class="fa fa-times"></i> Is outdated and could cause errors');
                    }
                }
            }, undefined, {dataType: 'json'});
            return false;
        });
        $('#btn-check-compatibility[data-toggle="tooltip"]').tooltip();
    });
</script>