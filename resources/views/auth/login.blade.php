@extends('layouts.app')

@section('content')
    <div class="text-center pt-8">
        <img src="/img/turbo_logo.svg">
    </div>

    <form class="p-6" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email" class="field__label">@lang('E-mail')</label>
            <input id="email" type="email" class="field__input" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
            <label for="password" class="field__label">@lang('Senha')</label>
            <input id="password" type="password" class="field__input" name="password" required>
        </div>

        <div class="field">
            <label class="field__label-checkbox">
                <input class="field__checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>@lang('Lembrar de mim')</span>
            </label>
        </div>

        <button type="submit" class="button button--primary">
            @lang('Entrar')
        </button>

        @if (Route::has('password.request'))
            <a class="button" href="{{ route('password.request') }}">
                @lang('Esqueceu sua senha?')
            </a>
        @endif
    </form>
@endsection
