
<div class="plugin plugin-news" data-plugin-placement="{{ $placement }}">
    @if($posts->count() == 0)
        <p class="text-center">Aucun article</p>
    @endif
	@foreach($posts as $post)
        <div class="news-post">
            <header class="news-post-header">
                <h3><a href="?post={{ $post->id }}">{{ $post->title }}</a></h3>
                <span>
                    <i class="fa fa-clock-o"></i> {{ $post->publishedAtFormatted() }}
                    <i class="fa fa-user"></i> {{ $post->author->displayName() }}
                </span>
            </header>
            <div class="news-post-text">
                <div class="row">
                    @if(isset($post->fkMedia) && $post->fkMedia != 0)

                        <div class="col-sm-3">
                            <!-- Preview Image -->
                            <img src="{{ asset($post->image()->path) }}" class="news-post-image" alt="{{ $post->title }}" />
                        </div>
                        <div class="col-sm-9">
                            <!-- Post Content -->
                            {!! $post->brief !!}
                        </div>

                    @else
                        <div class="col-sm-12">
                            <!-- Post Content -->
                            {!! $post->brief !!}
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <a href="?post={{ $post->id }}" class="btn btn-default"><i class="fa fa-chevron-right"></i> {{ __('Read more...') }}</a>
                    </div>
                </div>
            </div>
        </div>
	@endforeach
</div>