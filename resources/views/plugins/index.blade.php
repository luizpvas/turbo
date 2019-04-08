@extends('layouts.app')

@section('content')
    <div class="flex items-center px-3 py-2">
        <div class="mr-auto">
            <h1>@lang('Enabled plugins', ['website' => $website->name])</h1>
            <div class="italic text-grey-darkest">@lang("Here's a list of the currently enabled plugins")</div>
        </div>
        <a class="button" href="{{ route('websites.plugins.create', $website) }}">
            @lang('New plugin')
        </a>
    </div>

    @forelse($plugins as $plugin)
        <a class="block border-t no-underline p-3 text-grey-darkest hover:bg-yellow-lighter" href="{{ $plugin->rootPath($website) }}">
            <div class="text-xl block font-bold text-blue">{{ $plugin->instance()->name() }}</div>
            <div>{{ $plugin->instance()->description() }}</div>
        </a>
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
