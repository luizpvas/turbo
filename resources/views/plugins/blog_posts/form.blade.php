<div class="field">
    <label class="field__label">@lang('Title')</label>
    <input class="field__input" name="title" value="{{ $post->title }}">
</div>

<div class="field">
    <div data-controller="html-editor">
        <input type="hidden" name="body_html" id="body_html" value="{{ $post->body_html }}">
        <input type="hidden" data-target="html-editor.text" name="body_text" value="{{ $post->body_text }}">
        <trix-editor input="body_html"></trix-editor>
    </div> 
</div> 

<div class="field" data-controller="tags" data-tags-tags="{{ json_encode($post->tags) }}">
    <label class="field__label">@lang('Tags')</label>
    <input class="field__input" placeholder="@lang('Ex: Cooking, Traveling.')">
    <div data-target="tags.output" class="mt-1"></div>
</div>
