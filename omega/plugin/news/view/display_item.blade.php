@php
    $url = url()->current();
@endphp
<div class="plugin plugin-news" data-plugin-placement="{{ $placement }}">
    <div class="news-post">
        <div class="news-nav">
            <ul class="pager">
                @if(isset($previous))
                <li class="previous">
                    <a href="{{ $url }}?post={{ $previous->id }}">&larr; {{ __('Previous') }}</a>
                </li>
                @else
                <li class="previous disabled"><a>&larr; {{ __('Previous') }}</a></li>
                @endif
                <li><a href="{{ $url }}" data-toggle="tooltip" data-placement="bottom" title="{{ __('Back to list') }}"><i class="fa fa-list"></i></a></li>
                @if($next != null)
                <li class="next">
                    <a href="{{ $url }}?post={{ $next->id }}">{{ __('Next') }} &rarr;</a>
                </li>
                @else
                    <li class="next disabled"><a>{{ __('Next') }} &rarr;</a></li>
                @endif
            </ul>
        </div>
        <br />

         @if(isset($post))
            <h2>{{ $post->title }}</h2>

            <!-- Author -->
            <p class="lead">

                <span class="glyphicon glyphicon-time"></span>  {{ date('d.m.Y', strtotime($post->published_at)) }},


                <i class="fa fa-user"></i> {{ $post->author->displayName() }}
            </p>

            <hr>
            <div class="row">
                @if(isset($post->fkMedia) && $post->fkMedia != 0)

                    <div class="col-sm-3">
                        <!-- Preview Image -->
                        <img src="{{ asset($post->image()->path) }}" class="news-post-image" alt="{{ $post->title }}" />
                    </div>
                    <div class="col-sm-9">
                        <!-- Post Content -->
                        {!! $post->text !!}
                    </div>
                @else
                    <div class="col-sm-12">
                        {!! $post->text !!}
                    </div>
                @endif
            </div>
        @else
            <p class="text-center">
                This post does not exists...<br /><br />
                <a href="{{ $url }}" class="btn btn-default btn-lg">{{ __('Back to list') }}</a>
            </p>
        @endif
    </div>
</div>