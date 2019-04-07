<div class="w-1/4" style="" data-controller="attachment-item" data-attachment-item-id="{{ $attachment->id }}">
    <div class="m-1 border border-grey rounded overflow-hidden">
        <div class="p-1">
        @if($attachment->isImage())
            <img src="{{ $attachment->url }}" class="block w-full h-auto m-0 p-0 leading-none">
        @else
            <div class="bg-indigo h-16 flex items-center justify-center text-white font-bold uppercase">
                {{ $attachment->preview() }}
            </div>
        @endif
        </div>

        <div class="break-words text-center">
            <div class="text-xs py-2">{{ $attachment->name }}</div>

            <div class="flex my-2 text-sm">
                <a href="{{ $attachment->url }}"
                   title="@lang('Download')"
                   class="w-1/3 text-center text-grey-darker no-underline"
                >
                    <i class="fas fa-download"></i>
                </a>
                <a href="#"
                   title="@lang('Delete (cannot be recovered)')"
                   class="w-1/3 text-center text-grey-darker no-underline"
                   data-target="attachment-item.delete"
                >
                    <i class="fas fa-trash"></i>
                </a>
                <a href="{{ $attachment->url }}"
                   title="@lang('Copy URL')"
                   class="w-1/3 text-center text-grey-darker no-underline"
                   data-target="attachment-item.copy"
                >
                    <i class="fas fa-link"></i>
                </a>
            </div>
        </div>
    </div>
</div>
