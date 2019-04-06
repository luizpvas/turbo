@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1>@lang('HTML snippets for blog posts')</h1>
        <div class="text-sm italic text-grey-darkest">
            @lang('Here are some examples to help you get started with the blog engine.')
        </div>

        @if(request('view'))
            <pre class="border text-sm rounded p-2 mt-4"><code>{{ file_get_contents(resource_path('views/plugins/blog_examples/' . request('view') . '.html')) }}</code></pre>
        @else
            <div class="mt-4">
                <a class="block p-1" href="{{ route('websites.blog_examples.index', [website(), 'view' => 'example_index']) }}">
                    @lang('List of posts')
                </a>
                <a class="block p-1" href="{{ route('websites.blog_examples.index', [website(), 'view' => 'example_show']) }}">
                    @lang('Individual post page')
                </a>
            </div>
        @endif
    </div>
@endsection
