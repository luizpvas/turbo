@extends('layouts.app')

@section('content')
    <div class="sheet__header">
        <h1 class="sheet__title">@lang('Create a new mailing list')</h1>
    </div>

    <div class="p-6">
        <form method="post"
              action="{{ route('websites.mailing_lists.store', website()) }}"
              data-controller="form"
        >
            @csrf

            @include('plugins.mailing_lists.form')

            <button class="button button--primary" type="submit" data-target="form.submit">
                @lang('Create mailing list')
            </button>
        </form>
    </div>
@endsection
