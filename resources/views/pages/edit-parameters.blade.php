<div class="form-horizontal">
    <div class="form-group">
        {{ Form::label('name', __('Title'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            <div class="input-group">
                <span class="input-group-addon">
                    {{ Form::hidden('showName', 0) }}
                    {{ Form::checkbox('showName', 1, $page->showName) }}
                </span>
                {{ Form::text('name', $page->name, ['class' => 'form-control', 'paceholder' => __('Title')]) }}
            </div>
            @if ($errors->has('name'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('The title of the page') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('subtitle', __('Sub-title'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            <div class="input-group">
                <span class="input-group-addon">
                    {{ Form::hidden('showSubtitle', 0) }}
                    {{ Form::checkbox('showSubtitle', 1, $page->showSubtitle) }}
                </span>
                {{ Form::text('subtitle', $page->subtitle, ['class' => 'form-control', 'paceholder' => __('Sub-title')]) }}
            </div>
            @if ($errors->has('subtitle'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('subtitle') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('The sub-title of the page') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('slug', __('Slug'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::text('slug', $page->slug, ['class' => 'form-control', 'paceholder' => __('Slug')]) }}
            @if ($errors->has('slug'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('The slug is used in the URL') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('parent', __('Parent'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::select('parent', $pages, $page->fkPageParent, ['class' => 'form-control']) }}
            @if ($errors->has('parent'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('parent') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Define the parent of this page to organize your hierarchy.') }}
                </span>
            @endif
        </div>
    </div>


    @php $model = $page->model == null ? 'default' : $page->model @endphp
    <div class="form-group">
        {{ Form::label('model', __('Page template'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::Select('model', $models, $model, ['class' => 'form-control']) }}
            @if ($errors->has('model'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('model') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Define an alternative page template for this page.') }}
                </span>
            @endif
        </div>
    </div>


    @php $menu = $page->fkMenu == null ? 'null' : $page->fkMenu @endphp
    <div class="form-group">
        {{ Form::label('menu', __('Menu'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::Select('menu', $menus, $menu, ['class' => 'form-control']) }}
            @if ($errors->has('menu'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('menu') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Define the menu to use on this page.') }}
                </span>
            @endif
        </div>
    </div>


    @php $cssTheme = $page->cssTheme == null ? 'none' : $page->cssTheme @endphp
    <div class="form-group">
        {{ Form::label('cssTheme', __('Style'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::Select('cssTheme', $cssThemes, $cssTheme, ['class' => 'form-control']) }}
            @if ($errors->has('cssTheme'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('cssTheme') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Use a specific style for this page.') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('keyword', __('Keywords'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::textarea('keyword', $page->keyWords, ['class' => 'form-control']) }}
            @if ($errors->has('keyword'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('keyword') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Keywords for this page.') }}
                </span>
            @endif
        </div>
    </div>
</div>