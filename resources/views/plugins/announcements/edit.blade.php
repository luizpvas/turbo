@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex">
            <h1>@lang('Update the announcement')</h1>
            <a href="{{ route('websites.announcements.destroy', [website(), $announcement]) }}"
               data-method="DELETE"
               data-controller="remote-link"
            >
                @lang('Delete')
            </a>
        </div>

        <form method="post"
              action="{{ route('websites.announcements.update', [website(), $announcement]) }}"
              data-controller="form"
        >
            @csrf
            @method('put')

            @include('plugins.announcements.form')

            <button class="button button--primary" type="submit" data-target="form.submit">
                @lang('Save changes')
            </button>

            <a href="{{ url()->previous() }}" class="button">
                @lang('Go back')
            </a>
        </form>
    </div>
@endsection
