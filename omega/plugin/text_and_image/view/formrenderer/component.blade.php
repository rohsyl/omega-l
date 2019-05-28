<div class="row">
    <div class="col-sm-6">
        {!! $entries['text']->getHtml() !!}
    </div>


    <div class="col-sm-3">
        {!! $entries['picture']->getHtml() !!}
        {!! $entries['position']->getHtml() !!}
        {!! $entries['width_percent']->getHtml() !!}
    </div>

    <div class="col-sm-3">
        {!! $entries['resize']->getHtml() !!}
        {!! $entries['width']->getHtml() !!}
        {!! $entries['height']->getHtml() !!}
    </div>
</div>