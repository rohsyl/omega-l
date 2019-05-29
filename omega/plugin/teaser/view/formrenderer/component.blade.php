<div class="row">
    <div class="col-sm-8">
        {!! $entries['title']->getHtml() !!}
        {!! $entries['text']->getHtml() !!}
    </div>

    <div class="col-sm-4">
        {!! $entries['image']->getHtml() !!}
        {!! $entries['link']->getHtml() !!}
    </div>
</div>