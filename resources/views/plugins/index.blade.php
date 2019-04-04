@extends('layouts.app')

@section('content')
    <div class="flex items-center px-3 py-2">
        <div class="mr-auto">
            <h1>@lang(':website\'s plugins', ['website' => $website->name])</h1>
            <div class="italic text-grey-darkest">@lang("Here's a list of the currently enabled plugins")</div>
        </div>
        <a class="button" href="{{ route('websites.plugins.create', $website) }}">
            @lang('New plugin')
        </a>
    </div>

    @forelse($plugins as $plugin)
        <div class="p-4 border-t">
            <a class="text-xl block no-underline font-bold text-blue" href="{{ $plugin->rootPath($website) }}">{{ $plugin->instance()->name() }}</a>
            {{ $plugin->instance()->description() }}
        </div>
    @empty
        <div class="p-6 text-grey-darker">
            <div>@lang('You don\'t have any plugin enabled on this website right now.')</div>
            <div>
                @lang('<a href=":url">Click here</a> to enable your first plugin.', [
                    'url' => route('websites.plugins.create', $website)
                ])
            </div>
        </div>
    @endforelse
@endsection
