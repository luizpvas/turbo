@extends('layouts.app')

@section('content')
    <div class="sheet__header">
        <h1 class="sheet__title">@lang('Mailing lists')</h1>

        <div class="sheet__actions">
            <a class="button"
               href="{{ route('websites.mailing_lists.create', website()) }}"
            >
                @lang('New...')
            </a>
        </div>
    </div>

    @forelse($mailingLists as $mailingList)
        <a class="block no-underline w-full border-t p-3 hover:bg-yellow-lighter text-grey-darkest"
           href="{{ route('websites.mailing_lists.show', [website(), $mailingList]) }}"
        >
            <div class="flex items-center">
                <div class="mr-auto font-bold">{{ $mailingList->name }}</div>
                <div class="text-sm">{{ $mailingList->created_at->diffForHumans() }}</div>
            </div>

            <div class="text-sm">
                @lang(':n subscriptions', ['n' => $mailingList->subscriptions_count])
            </div>
        </a>
    @empty
        <div class="p-6 text-grey-darker italic">
            <div>@lang("You don't have any mailing lists yet.")</div>
            <div>
                @lang('<a href=":url">Click here</a> to create your first mailing list.', [
                    'url' => route('websites.mailing_lists.create', website())
                ])
            </div>
        </div>
    @endforelse
@endsection
