@extends('layouts.app')

@section('content')
    <div class="flex items-center px-4 py-2">
        <h1 class="mr-auto">@lang('Blog posts')</h1>
        <a class="button"
           href="{{ route('websites.blog_posts.create', website()) }}"
        >
            @lang('Write new post...')
        </a>
    </div>

    @forelse($posts as $post)
        <a class="block border-t p-3"
           href="{{ route('websites.blog_posts.edit', [website(), $post]) }}"
        >
            {{ $post->title }}
        </a>
    @empty
        <div class="p-6 text-grey-darker">
            <div>@lang("You don't have any posts yet.")</div>
            <div>
                @lang('<a href=":url">Click here</a> to write your first post.', [
                    'url' => route('websites.blog_posts.create', website())
                ])
            </div>
        </div>
    @endforelse
@endsection
