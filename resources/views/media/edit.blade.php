
{{ Form::open(['id' => 'editMediaForm', 'data-enable-lang' => $langEnabled]) }}
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#any" aria-controls="any" role="tab" data-toggle="tab">{{ __('Any') }}</a></li>
            @if($langEnabled)
                @foreach($langs as $l)
                    <li role="presentation"><a href="#{{ $l->slug }}" aria-controls="{{ $l->slug }}" role="tab" data-toggle="tab">{{ $l->name }}</a></li>
                @endforeach
            @endif
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="any">
                <br />
                <!-- Text input - title -->
                <div class="form-group">
                    <label class="control-label" for="title">Title</label>
                    <input id="title" name="title" placeholder="Title" class="form-control input-md" type="text" value="{{ $media->title }}">
                </div>
                <!-- Text input - descr -->
                <div class="form-group">
                    <label class="control-label" for="description">Description</label>
                    <input id="description" name="description" placeholder="Description" class="form-control input-md" type="text" value="{{ $media->description }}">
                </div>
            </div>
            @if($langEnabled)
                @foreach($langs as $l)
                    <div role="tabpanel" class="tab-pane" id="{{ $l->slug }}">
                        <br />
                        <!-- Text input - title -->
                        <div class="form-group">
                            <label class="control-label" for="title_{{ $l->slug }}">Title</label>
                            <input id="title_{{ $l->slug }}" name="titles[{{ $l->slug }}]" data-lang-slug="{{ $l->slug }}" placeholder="Title" class="form-control input-md" type="text" value="{{ $media->getTitle($l->slug) }}">
                        </div>
                        <!-- Text input - descr -->
                        <div class="form-group">
                            <label class="control-label" for="description_{{ $l->slug }}">Description</label>
                            <input id="description_{{ $l->slug }}" name="descriptions[{{ $l->slug }}]" data-lang-slug="{{ $l->slug }}" placeholder="Description" class="form-control input-md" type="text" value="{{ $media->getDescription($l->slug) }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
{{ Form::close() }}