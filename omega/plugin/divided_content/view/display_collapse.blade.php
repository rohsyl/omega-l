@php
    $componentsView = array();
    if(isset($page['value'])){
        $page = new \Omega\Utils\Entity\Page($page['value']);
        $componentsView = $page->getComponentsViewArray();
    }
@endphp

<div class="panel-group" id="accordion{{ $id }}" role="tablist" aria-multiselectable="true">

    @php $i = 0; @endphp
    @foreach($componentsView as $v)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{ $i . '-' . $id }}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion{{ $id }}" href="#collapse{{ $i . '-' . $id }}" aria-expanded="true" aria-controls="collapse{{ $i . '-' . $id }}">
                        {{ $v['title'] }}
                    </a>
                </h4>
            </div>
            <div id="collapse{{ $i . '-' . $id }}" class="panel-collapse collapse {{ $i == 0 ? 'in' : '' }}" role="tabpanel" aria-labelledby="heading{{ $i . '-' . $id }}">
                <div class="panel-body">
                    {!! $v['html'] !!}
                </div>
            </div>
        </div>
        @php $i++; @endphp
    @endforeach
</div>