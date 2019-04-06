@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-center mb-4">@lang('Blog Settings')</h1>

    <form method="post"
          action="{{ route('websites.blog_engines.update', [website(), $engine]) }}"
          data-controller="form"
    >
        @csrf
        @method('put')

        <div class="field">
            <label class="field__label">@lang('URL path for individual blog posts')</label>
            <input class="field__input" name="blog_post_path" value="{{ $engine->blog_post_path }}">
            <div class="text-sm text-grey-darker">
                @lang("Each blog post has a unique ID that will be appended at the end of the URL. For example, /blog/post/my-post-title.")
            </div>
        </div>

        <div class="field">
            <label class="field__label">@lang('Amount of posts per page')</label>
            <input class="field__input" name="posts_per_page" type="number" value="{{ $engine->posts_per_page }}">
            <div class="text-sm text-grey-darker">
                @lang("The results will be paginated if you have more than the amount of posts per page.")
            </div>
        </div>

        <button type="submit" class="button button--primary">
            @lang('Save changes')
        </button>
    </form>
</div>
@endsection
