@php
    $url = isset($page) ? \Omega\Utils\Entity\Page::GetUrl($page['value']) : '';
@endphp
<div class="plugin-news-container" data-plugin-placement="{{ $placement }}">
    <div class="row">
        @if($posts->count() == 0)
        @endif
        @forelse($posts as $post)
            <div class="col-4">
                <div class="news-post">
                    <header class="news-post-header">
                        <h3><a href="{{ $url }}?post={{ $post->slug }}">{{ $post->title }}</a>
                        </h3>
                        <small>
                            <i class="fa fa-clock-o"></i> {{ date('d.m.Y', strtotime($post->published_at)) }} <br />
                            <i class="fa fa-user"></i> {{ $post->author->displayName() }}
                        </small>
                    </header>
                    <div class="news-post-text">
                        @if($post->image() != null)

                            <img src="{{ asset($post->image()->path) }}" class="news-post-image" alt="{{ $post->title }}" />
                            <!-- Post Content -->
                            {!! $post->brief !!}
                            <a href="{{ $url }}?post={{ $post->slug }}" class="btn btn-default pull-right" ><i class="fa fa-chevron-right"></i> {{ __('Read more...') }}</a>

                        @else
                            <!-- Post Content -->
                            {!! $post->brief !!}
                            <a href="{{ $url }}?post={{ $post->slug }}" class="btn btn-default pull-right"><i class="fa fa-chevron-right"></i> {{ __('Read more...') }}</a>
                            @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p class="text-center">Aucun article</p>
            </div>
        @endforelse
    </div>
</div>