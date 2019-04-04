@extends('layouts.app')

@section('content')
    <div class="flex items-center py-3 px-4">
        <h1 class="text-2xl mr-auto text-grey-darkest">@lang('Your websites')</h1>

        <a class="button" href="{{ route('websites.create') }}">
            @lang('Create a new website')
        </a>
    </div>

    @foreach($websites as $website)
        <div class="block no-underline border-t p-4 text-grey-darkest hover:bg-yellow-lightest">
            <a class="flex items-center no-underline text-grey-darkest"
               href="{{ route('websites.show', $website) }}"
            >
                <h2 class="mr-auto">{{ $website->name }}</h2>
                <span class="text-sm text-grey-darker">
                    @lang('Created :diff', [
                        'diff' => $website->created_at->diffForHumans()
                    ])
                </span>
            </a>

            @lang('Acesse o site pelo <a href=":domain">domínio</a> ou <a href=":subdomain">subdomínio</a>', [
                'domain' => 'https://' . $website->domain,
                'subdomain' => $website->route('/')
            ])
        </div>
    @endforeach
@endsection
