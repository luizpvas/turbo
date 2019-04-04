@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="text-center text-grey-darkest">
            <h1>{{ $post->title }}</h1>
            <div class="italic text-sm">
                @if ($post->isPublished())
                    @lang('This post was published :time', ['time' => $post->published_at->diffForHumans()])
                @else
                    @lang('This post is still a draft. You can publish it at any moment.')
                @endif
            </div>
        </div>

        <form method="post"
              action="{{ route('websites.blog_posts.update', [website(), $post]) }}"
              data-controller="form"
        >
            @csrf
            @method('put')

            @include('plugins.blog_posts.form')

            @if ($post->isPublished())
                <button class="button button--primary" type="submit">
                    @lang('Save changes')
                </button>

                <button class="button button"
                        type="submit"
                        data-additional-attributes="{{ json_encode(['published_at' => null]) }}"
                >
                    @lang('Unpublish (save as draft)')
                </button>
            @else
                <button class="button button" type="submit">
                    @lang('Save as draft')
                </button>

                <button class="button button--primary"
                        type="submit"
                        data-additional-attributes="{{ json_encode(['published_at' => now()->toDateTimeString()]) }}"
                >
                    @lang('Publish (make it public)')
                </button>
            @endif
        </form>
    </div>
@endsection
