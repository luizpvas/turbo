<div class="field">
    <label class="field__label">@lang('Title')</label>
    <input class="field__input" name="title" value="{{ $announcement->title }}">
</div>

<div class="field">
    <div data-controller="html-editor">
        <input type="hidden" name="body_html" id="body_html" value="{{ $announcement->body_html }}">
        <input type="hidden" data-target="html-editor.text" name="body_text" value="{{ $announcement->body_text }}">
        <trix-editor input="body_html"></trix-editor>
    </div> 
</div> 

<div class="field">
    <label class="field__label-checkbox">
        <input type="hidden" name="is_highlighted" value="off">
        <input class="field__checkbox" type="checkbox" name="is_highlighted" {{ $announcement->is_highlighted ? 'checked': '' }}>
        <span>@lang('Mark as highlighted')</span>
    </label>
</div>
