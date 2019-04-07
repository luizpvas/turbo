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

    @if(request('page', 1) == 1)
        <div class="p-3 m-3 border-2 border-yellow bg-yellow-lightest rounded text-yellow-darker text-sm">
            @lang('Here are some links to help you manage and customize your blog')

            <a class="block p-1" href="{{ route('websites.blog_engines.edit', [website(), $engine]) }}">
                <i class="fas fa-fw fa-cog"></i>
                @lang('Settings - Such as the amount of posts per page and the URL for individual posts')
            </a>
            <a class="block p-1" href="{{ route('websites.blog_examples.index', website()) }}">
                <i class="fas fa-fw fa-code"></i>
                @lang('Examples - HTML snippets to help you customize your website.')
            </a>
        </div>
    @endif

    @forelse($posts as $post)
        <a class="block border-t p-3 no-underline text-grey-darkest relative hover:bg-yellow-lighter"
           href="{{ route('websites.blog_posts.edit', [website(), $post]) }}"
        >
            <div class="absolute pin-t pin-r mt-3 mr-3">
                {!! \App\Plugins\Blog::renderTags($post->tags) !!}
            </div>

            <div class="font-bold text-xl">
                {{ $post->title }}
            </div>


            <div class="text-sm">
                @if($post->isPublished())
                    @lang('Published by <b>:name</b> :time', ['name' => $post->author->name, 'time' => $post->published_at->diffForHumans()])
                @else
                    @lang('Saved as draft by <b>:name</b> :time', ['name' => $post->author->name, 'time' => $post->created_at->diffForHumans()])
                @endif
            </div>
        </a>
    @empty
        <div class="p-6 text-grey-darker italic">
            <div>@lang("You don't have any posts yet.")</div>
            <div>
                @lang('<a href=":url">Click here</a> to write your first post.', [
                    'url' => route('websites.blog_posts.create', website())
                ])
            </div>
        </div>
    @endforelse
@endsection
