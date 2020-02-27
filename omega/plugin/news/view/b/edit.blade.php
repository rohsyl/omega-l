@extends('layouts.plugin')

@section('plugin_content')
    {!! $menu !!}

    {{ Form::open(['url' => route_plugin('news', 'save', ['id' => $item->id]), 'method' => 'post', 'class' => 'form-horizontal main-form']) }}

    <div class="row">
        <div class="col-sm-8">
            {{ Form::label('title', __('Title'), ['class' => 'control-label']) }}
            {{ Form::text('title', $item->title, ['class' => 'form-control', 'placeholder' => __('Title')]) }}
            @if($errors->has('title'))
                <span class="text-danger">
                {{ $errors->first('title') }}
            </span>
            @endif
            <div class="text-muted">{{ __('The title of the post') }}</div>


            {{ Form::label('brief', __('Brief'), ['class' => 'control-label']) }}
            {{ Form::textarea('brief', $item->brief, ['class' => 'summernote', 'height' => '200']) }}
            @if($errors->has('brief'))
                <span class="text-danger">
                {{ $errors->first('brief') }}
            </span>
            @endif
            <div class="text-muted" style="margin-top: -20px;">{{ __('A short introduction to your post') }}</div>

            {{ Form::label('text', __('Text'), ['class' => 'control-label']) }}
            {{ Form::textarea('text', $item->text, ['class' => 'summernote']) }}
            @if($errors->has('text'))
                <span class="text-danger">
                {{ $errors->first('text') }}
            </span>
            @endif
            <div class="text-muted" style="margin-top: -20px;">{{ __('The full text of your post') }}</div>


        </div>

        <div class="col-sm-4">

            {{ Form::label('published_at', __('Publish date'), ['class' => 'control-label']) }}
            {{ Form::omdate('published_at', isset($item->published_at) ? date('Y-m-d', strtotime($item->published_at)) : null, ['class' => 'form-control', 'id' => 'published_at']) }}
            @if($errors->has('published_at'))
                <span class="text-danger">
                {{ $errors->first('published_at') }}
            </span>
            @endif
            <div class="text-muted">{{ __('When the post will be publised') }}</div>

            {{ Form::label('image', __('Image'), ['class' => 'control-label']) }}
            {{ Form::omMediaChooser('image', __('Image'), $item->media_id) }}
            @if($errors->has('image'))
                <span class="text-danger">
                {{ $errors->first('image') }}
            </span>
            @endif

            @if(isset($item->fkMedia))
                <br />
                <div class="img-thumbnail">
                    <img src="{{ asset($item->image()->path) }}" alt="post-image" width="100%"/>
                </div>
            @endif
            <br />

            {{ Form::label('categories', __('Catgories'), ['class' => 'control-label']) }}
            @if($categories->count() == 0)
                <div class="text-muted">{{ __('No category') }}</div>
            @endif
            @foreach($categories as $category)
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('categories[]', $category->id, $item->categories->contains($category->id)) }}
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach


            <p class="text-right"><br />
                <button id="btnSave" name="btnSave" class="btn btn-primary">{{ __('Save') }}</button>
            </p>
        </div>
    </div>
    {{ Form::close() }}

    <script>
        omega.initSummerNote('#text');
        omega.initSummerNote('#brief');
        omega.initDatePicker('#published_at');
    </script>

@endsection