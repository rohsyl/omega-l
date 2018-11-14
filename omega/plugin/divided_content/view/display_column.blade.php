@php
$componentsView = array();
$colClass = 'col-sm-' . (12 / $countCol);
if(isset($page['value'])){
    $page = new \Omega\Utils\Entity\Page($page['value']);
    $componentsView = $page->getComponentsViewArray();
}
@endphp

<div class="row">
    @foreach($componentsView as $v)
        <div class="{{ $colClass }}">
            {!! $v['html'] !!}
        </div>
    @endforeach
</div>
