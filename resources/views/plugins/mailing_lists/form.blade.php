<div class="field">
    <label class="field__label">@lang('Name')</label>
    <input class="field__input"
           name="name"
           placeholder="@lang('Ex: People from home page')"
           value="{{ $mailingList->name }}"
    >
</div>

@if($mailingList->exists)
<div class="field">
    <div data-controller="html-editor">
        <label class="field__label">@lang('Subscription created.')</label>
        <input type="hidden" name="subscribed_success_template" id="subscribed_success_template" value="{{ $mailingList->subscribed_success_template }}">
        <input type="hidden" data-target="html-editor.text">
        <trix-editor input="subscribed_success_template"></trix-editor>
    </div> 
</div> 

<div class="field">
    <div data-controller="html-editor">
        <label class="field__label">@lang('E-mail already subscribed.')</label>
        <input type="hidden" name="already_subscribed_template" id="already_subscribed_template" value="{{ $mailingList->already_subscribed_template }}">
        <input type="hidden" data-target="html-editor.text">
        <trix-editor input="already_subscribed_template"></trix-editor>
    </div> 
</div> 
@endif
