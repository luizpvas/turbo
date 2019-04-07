@extends('layouts.app')

@section('content')
    <div class="text-center border-b">
        <h1>{{ $website->name }}</h1>
        <div class="italic text-grey-darker">{{ $website->domain }}</div>
    </div>

    <div>
        <a href="{{ route('websites.plugins.index', $website) }}"
           class="flex items-center no-underline text-black hover:bg-yellow-lighter"
        >
            <div class="w-32 p-2 ml-2 mr-4 flex-no-shrink">
                <img src="/img/undraw/website_setup.svg" class="w-full">
            </div>
            
            <div>
                <h2>@lang('Plugins')</h2>
                @lang('Manage the website\'s plugins, such as blog posts, mailing lists and contact forms.')
            </div>
        </a>

        <a href="{{ route('websites.deployment_settings.index', $website) }}"
           class="flex items-center no-underline text-black hover:bg-yellow-lighter"
        >
            <div class="w-32 p-2 ml-2 mr-4 flex-no-shrink">
                <img src="/img/undraw/server.svg" class="w-full">
            </div>

            <div>
                <h2>@lang('Deployments')</h2>
                @lang('See the history of deployments and the status of your website.')
            </div>
        </a>

        <a href="{{ route('websites.attachments.index', $website) }}"
           class="flex items-center no-underline text-black hover:bg-yellow-lighter"
        >
            <div class="w-32 p-2 ml-2 mr-4 flex-no-shrink">
                <img src="/img/undraw/static_assets.svg" class="w-full">
            </div>

            <div>
                <h2>@lang('Assets')</h2>
                @lang('Upload your images, JS scripts and CSS styles.')
            </div>
        </a>

    </div>
@endsection
