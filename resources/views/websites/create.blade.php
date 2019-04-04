@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1>@lang('Novo website')</h1>

        <form method="post" action="{{ route('websites.store') }}"
              data-controller="form"
        >
            @csrf

            <div class="field">
                <label class="field__label">@lang('Nome do website')</label>
                <input class="field__input" name="name">
            </div>

            <div class="field">
                <label class="field__label">@lang('Domínio (opcional)')</label>
                <input class="field__input" name="domain">
                <span class="text-sm italic text-grey-darker">
                    @lang('Você pode deixar em branco caso ainda não tenha um domínio registrado.')
                </span>
            </div>

            <div class="field">
                <label class="field__label">@lang('Subdomínio')</label>
                <input class="field__input" name="subdomain">
                <span class="text-sm italic text-grey-darker">
                    @lang('Seu website também poderá ser acessado por um subdomínio dentro da plataforma turbo.')
                </span>
            </div>

            <button type="submit" class="button button--primary" data-target="form.submit">
                @lang('Cadastrar website')
            </button>
        </form>
    </div>
@endsection
