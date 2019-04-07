<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Turbo.</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans leading-normal bg-turbo-green">
    @if(auth()->check())
        <div class="text-center py-3">
            @lang('Logged in as')

            <select class="border bg-white" data-controller="app-dropdown-menu">
                <option>{{ auth()->user()->name }}</option>
                <option value="websites">@lang('My websites')</option>
                <option value="logout">@lang('Logout')</option>
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
