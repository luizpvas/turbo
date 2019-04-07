@extends('layouts.app')

@section('content')
    <div class="sheet__header">
        <h1 class="sheet__title">@lang('Update mailing list')</h1>
    </div>

    <div class="p-6">
        <form method="post"
              action="{{ route('websites.mailing_lists.update', [website(), $mailingList]) }}"
              data-controller="form"
        >
            @csrf
            @method('put')

            @include('plugins.mailing_lists.form')

            <button class="button button--primary" type="submit" data-target="form.submit">
                @lang('Save changes')
            </button>
        </form>
    </div>
@endsection
