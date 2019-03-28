@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Datatypes') }}</h1>


    <div class="alert alert-info">
        {{ __('Datatypes are used to create components and modules form.') }}
    </div>

    <p>
        {{ __('To create a new component/module, you must create a plugin and then create a new "form" with "form_entry" in it.') }}<br />
        {{ __('The creation of "form" is done with') }} <code>FormFactory::newForm()</code>.<br />

    </p>
    <p>
        <strong>{{ __('Exemple') }} :</strong>
    </p>
<pre>
&lt;?php
    FormFactory::newForm('[plugin_name]', '[form_name]', [is_module], [is_component], '[form_title');
?&gt;
</pre>


    <p>{{ __('And then add form_entry with the following types') }} :</p>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @php $i = 0; @endphp
        @foreach($datatypes as $dt)
            @php
            $instance = new $dt(null, null, null, null);
            $className = get_class($instance);
            $xplodName = explode('\\', $className);
            $key = str_slug($xplodName[sizeof($xplodName)-1]);
            @endphp
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="{{ $key }}Heading">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{ $key }}Collapse" aria-expanded="true" aria-controls="{{ $key }}Collapse">
                            {{ $className }}
                        </a>
                    </h4>
                </div>
                <div id="{{ $key }}Collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $key }}Heading">
                    <div class="panel-body">
                        {!! $instance->getDoc() !!}
                    </div>
                </div>
            </div>
            @php $i++; @endphp
        @endforeach
    </div>
    <div class="alert alert-warning">
        {{ __('All these methods must be executed only once and generally are when installing the plugin in a migration file.') }}
    </div>
@endsection