@php
    $componentsView = array();
    if(isset($page['value'])){
        $page = new \Omega\Utils\Entity\Page($page['value']);
        $componentsView = $page->getComponentsViewArray();
    }
@endphp

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    @php $i = 0; @endphp
    @foreach($componentsView as $v)
        <li role="presentation" class="{{ $i == 0 ? 'active' : '' }}">
            <a href="#{{ str_slug($v['title']) }}" aria-controls="home" role="tab" data-toggle="tab">
                {{ $v['title'] }}
            </a>
        </li>
    @php $i++; @endphp
    @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content">
    @php $i = 0; @endphp
    @foreach($componentsView as $v)
        <div role="tabpanel" class="tab-pane {{ $i == 0 ? 'active' : '' }}" id="{{ str_slug($v['title']) }}">
            {!! $v['html'] !!}
        </div>
    @php $i++; @endphp
    @endforeach
</div>