@extends('layouts.app')

@section('content')
<div class="flex items-center px-4 py-2">
    <h1 class="mr-auto">@lang('Announcements')</h1>
    <a class="button"
       href="{{ route('websites.announcements.create', website()) }}"
       title="@lang('Publish new announcement')"
    >
        @lang('New...')
    </a>
</div>

@if(request('page', 1) == 1)
    <div class="p-3 m-3 border-2 border-yellow bg-yellow-lightest rounded text-yellow-darker text-sm">
        @lang('Here are some links to help you manage and customize your announcements')

        <a class="block p-1" href="{{ route('websites.announcements_examples.index', website()) }}">
            <i class="fas fa-fw fa-code"></i>
            @lang('Examples - HTML snippets to help you customize your website.')
        </a>
    </div>
@endif

@forelse($announcements as $announcement)
    <a href="{{ route('websites.announcements.edit', [website(), $announcement]) }}"
       class="block no-underline text-black hover:bg-yellow-lighter border-t p-4"
    >
        <div class="flex items-center">
            <h2 class="mr-auto">
                {{ $announcement->title }}

                @if($announcement->is_highlighted)
                    <div class="bg-yellow-dark text-white text-xs inline align-top rounded px-1">
                        @lang('Highlighted')
                    </div>
                @endif
            </h2>
            <div class="text-sm text-grey-darker">{{ $announcement->created_at->diffForHumans() }}</div>
        </div>

        {!! $announcement->body_html !!}
    </a>
@empty
    <div class="p-4 italic text-grey-darker">
        @lang("You don't have any announcements yet.")<br>
        @lang('<a href=":url">Click here</a> to create your first announcement.', [
            'url' => route('websites.announcements.create', website())
        ])
    </div>
@endforelse

@if($announcements->hasPages())
    <div class="p-3 border-t">
        {!! $announcements->appends($_GET)->render() !!}
    </div>
@endif

@endsection

