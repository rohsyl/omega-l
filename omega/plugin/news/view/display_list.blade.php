
<div class="plugin-news-container" data-plugin-placement="{{ $placement }}">
    @if($posts->count() == 0)
        <p class="text-center">Aucun article</p>
    @endif
	@foreach($posts as $post)
        <div class="news-post">
            <header class="news-post-header">
                <h3><a href="?post={{ $post->id }}">{{ $post->title }}</a>
                    <br />
                <small>
                    <i class="fa fa-clock-o"></i> {{ date('d.m.Y', strtotime($post->published_at)) }}
                    <i class="fa fa-user"></i> {{ $post->author->displayName() }}
                </small>
                </h3>
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
                            <a href="?post={{ $post->id }}" class="btn btn-default pull-right" ><i class="fa fa-chevron-right"></i> {{ __('Read more...') }}</a>
                        </div>

                    @else
                        <div class="col-sm-12">
                            <!-- Post Content -->
                            {!! $post->brief !!}
                            <a href="?post={{ $post->id }}" class="btn btn-default pull-right"><i class="fa fa-chevron-right"></i> {{ __('Read more...') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
	@endforeach
</div>