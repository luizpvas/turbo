@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1>@lang('HTML snippets for mailing lists')</h1>
        <div class="text-sm italic text-grey-darkest">
            @lang('Here are some examples to help you get started with customizing your mailing list.')
        </div>

        @if(request('view'))
            <pre class="border text-sm rounded p-2 mt-4"><code>{{ render_example(resource_path('views/plugins/mailing_list_examples/' . request('view') . '.html'), ['id' => $mailingList->id]) }}</code></pre>
        @else
            <div class="p-2">
                <a href="{{ route('websites.mailing_list_examples.index', [website(), 'mailing_list_id' => $mailingList->id, 'view' => 'example_subscription_panel']) }}">
                    @lang('Subscription panel')
                </a>
            </div>
        @endif
    </div>
@endsection
