<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Turbo.</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans leading-normal bg-turbo-green">
    @if(auth()->check())
        <div class="text-center py-3">
            @lang('Logged in as')

            <select class="border bg-white">
                <option>{{ auth()->user()->name }}</option>
                <option>@lang('My websites')</option>
                <option>@lang('Logout')</option>
            </select>
        </div>
    @endif

    @if(count(sheets()) > 0 || website())
        <div class="backsheet">
            @if(website())
                <a href="{{ route('websites.show', website()) }}">
                    {{ website()->name }}
                </a>
            @endif

            @foreach(sheets() as $index => $sheet)
                @if($index == 0 && website())
                &nbsp;&middot;&nbsp;
                @elseif($index > 0)
                &nbsp;&middot;&nbsp;
                @endif

                <a href="{{ $sheet['route'] }}">
                    {{ $sheet['label'] }}
                </a>
            @endforeach
        </div>
    @endif

    <main class="sheet">
        @yield('content')
    </main>
</body>
</html>
