@extends('layouts.app')

@section('content')
    <div class="p-2">
        <h1 class="text-center p-2">
            @lang('Add a plugin to :website', ['website' => $website->name])
        </h1>

        @foreach($availablePlugins as $plugin)
            <a class="block border-t p-4 no-underline text-grey-darkest hover:bg-yellow-lightest"
               href="{{ route('websites.enabled_plugins.store', [$website, 'plugin_class' => get_class($plugin)]) }}"
               title="@lang('Enable this plugin.')"
               data-controller="remote-link"
               data-method="POST"
            >
                <h2>{{ $plugin->name() }}</h2>
                <div>{{ $plugin->description() }}</div>
            </a>
        @endforeach
    </div>
@endsection
