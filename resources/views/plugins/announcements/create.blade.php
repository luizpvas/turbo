@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1>@lang('Publish a new announcement')</h1>

        <form method="post"
              action="{{ route('websites.announcements.store', website()) }}"
              data-controller="form"
        >
            @csrf

            @include('plugins.announcements.form')

            <button class="button button--primary" type="submit" data-target="form.submit">
                @lang('Publish announcement')
            </button>
        </form>
    </div>
@endsection
