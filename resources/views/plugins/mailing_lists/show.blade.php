@extends('layouts.app')

@section('content')
    <div class="sheet__header">
        <h1 class="sheet__title">{{ $mailingList->name }}</h1>
        <div class="sheet__actions">
            <a class="mr-2 text-sm no-underline"
               href="{{ route('websites.mailing_lists.edit', [website(), $mailingList]) }}"
            >
                <i class="fas fa-edit"></i>
                @lang('Edit')
            </a>
            <a class="text-sm no-underline"
               href="{{ route('websites.mailing_lists.destroy', [website(), $mailingList]) }}"
               data-controller="remote-link"
               data-method="DELETE"
            >
                <i class="fas fa-trash"></i>
                @lang('Archive')
            </a>
        </div>
    </div>

    <div class="p-2">
        <div class="tips">
            @lang('Here are some links to you help you customize the mailing list form.')

            <a class="block p-1"
               href="{{ route('websites.mailing_list_examples.index', [website(), 'mailing_list_id' => $mailingList->id]) }}"
            >
                <i class="fas fa-code"></i>
                @lang('HTML snippets to help you get started')
            </a>
        </div>
    </div>

    @if($subscriptions->count() > 0)
        <div class="p-2 font-bold text-blue">
            @lang('Subscriptions (:total)', ['total' => $subscriptions->total()])
        </div>
    @endif

    @forelse($subscriptions as $subscription)
        <div class="border-t p-3">
            <div class="flex items-center">
                <div class="font-bold mr-auto">{{ $subscription->email }}</div>
                <span class="text-grey-darker text-sm">
                    {{ $subscription->created_at->diffForHumans() }}
                </span>
            </div>

            <table class="text-sm font-mono mt-2">
                @foreach($subscription->attrs ?? [] as $key => $value)
                    <tr>
                        <td class="pr-2 text-right font-bold text-yellow-darker">{{ $key }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @empty
        <div class="p-6 text-grey-darkest italic">
            @lang('There are no subscriptions in this mailing list yet.')
        </div>
    @endforelse
@endsection
