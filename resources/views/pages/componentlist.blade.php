@foreach($components as $component)
<div class="component-item" id="component-{{ $component['id'] }}">
    <div class="component-item-top">
        <ul>
            @php
            $class = isset($component['args']['settings']['bgColorType']) && $component['args']['settings']['bgColorType'] == 'transparent'
                ? ' transparent'
                : '';
            $style = isset($component['args']['settings']['bgColorType']) && isset($component['args']['settings']['bgColor']) && $component['args']['settings']['bgColorType'] != 'transparent'
                ? 'style="background-color: '.$component['args']['settings']['bgColor'].';"'
                : '';
            @endphp
            <li>
                <span class="component-item-bgcolor{{ $class }}" {{ $style }} id="bg-comp-{{ $component['id'] }}"></span>
                {{ $component['pluginMeta']->getTitle() }}
            </li>

            @if(isset($component['args']['settings']['isHidden']))
                {!! $component['args']['settings']['isHidden'] ? '<li><i class="fa fa-eye-slash" id="hidden-comp-'.$component['id'].'"></i></li>' : '' !!}
            @endif
            @if(isset($component['args']['settings']['isWrapped']))
                {!! !$component['args']['settings']['isWrapped'] ? '<li><i class="fa fa-arrows-h" id="fullwidth-comp-'.$component['id'].'"></i></li>' : '' !!}
            @endif
            @if(isset($component['args']['settings']['pluginTemplate']))
                {!! $component['args']['settings']['pluginTemplate'] != 'null' ? '<li><i class="fa fa-exclamation-circle" id="template-comp-'.$component['id'].'"></i></li>' : '' !!}
            @endif
            @if(isset($component['args']['settings']['compId']))
                {!! !empty($component['args']['settings']['compId']) ? '<li><i class="fa fa-hashtag" id="id-comp-'.$component['id'].'"></i>'.$component['args']['settings']['compId'].'</li>' : '' !!}
            @endif

        </ul>

    </div>
    <div class="component-item-container">
        {!! $component['html'] !!}
        <div class="component-item-actions">
            <a href="#" class="settingsComponent" data-id="{{ $component['id'] }}"><i class="fa fa-cog"></i></a>
            <a href="#" class="deleteComponent" data-id="{{ $component['id'] }}"><i class="fa fa-trash"></i></a>

            <a href="#" class="upupComponent @if($loop->first) hidden  @endif" data-id="{{ $component['id'] }}"><i class="fa fa-angle-double-up"></i></a>
            <a href="#" class="upComponent  @if($loop->first) hidden  @endif" data-id="{{ $component['id'] }}"><i class="fa fa-angle-up"></i></a>
            <a href="#" class="downComponent @if($loop->last) hidden  @endif" data-id="{{ $component['id'] }}"><i class="fa fa-angle-down"></i></a>
            <a href="#" class="downdownComponent @if($loop->last) hidden  @endif" data-id="{{ $component['id'] }}"><i class="fa fa-angle-double-down"></i></a>
        </div>
    </div>
</div>
@endforeach