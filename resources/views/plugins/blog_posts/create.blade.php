@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="text-center text-grey-darkest">
            <h1>@lang('Write a new blog post')</h1>
            <div class="italic text-sm">@lang('Posts are not published by default (you can publish in the next screen)')</div>
        </div>

        <form method="post"
              action="{{ route('websites.blog_posts.store', website()) }}"
              data-controller="form"
        >
            @csrf

            @include('plugins.blog_posts.form')

            <button class="button button--primary" type="submit" data-target="form.submit">
                @lang('Save as draft')
            </button>
        </form>
    </div>
@endsection
