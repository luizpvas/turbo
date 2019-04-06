@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1>@lang('HTML snippets for announcements')</h1>
        <div class="text-sm italic text-grey-darkest">
            @lang('Here are some examples to help you get started with announcements.')
        </div>

        @if(request('view'))
            <pre class="border text-sm rounded p-2 mt-4"><code>{{ file_get_contents(resource_path('views/plugins/announcements_examples/' . request('view') . '.html')) }}</code></pre>
        @else
            <div class="mt-4">
                <a class="block p-1" href="{{ route('websites.announcements_examples.index', [website(), 'view' => 'example_index']) }}">
                    @lang('List of announcements')
                </a>
                <a class="block p-1" href="{{ route('websites.announcements_examples.index', [website(), 'view' => 'example_highlighted']) }}">
                    @lang('Highlighted announcement')
                </a>
            </div>
        @endif
    </div>
@endsection
