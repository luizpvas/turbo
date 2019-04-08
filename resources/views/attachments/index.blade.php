@extends('layouts.app')

@section('content')
    <div class="p-6" data-controller="attachments" data-attachments-website-id="{{ website()->id }}">
        <div class="border-2 border-dashed border-yellow rounded p-3 text-sm text-center bg-yellow-lightest"
             data-target="attachments.drop"
        >
            <div class="mb-2">
                @lang('Drag and drop files here or click the input below to upload your assets.')
            </div>
            <input type="file" name="file" multiple data-target="attachments.upload">
        </div>

        <div class="my-2" data-target="attachments.progress"></div>

        <div class="text-center my-3">
            <h1>@lang('Attachments (:total)', ['total' => $attachments->total()])</h1>
        </div>

        <div class="flex flex-wrap" data-target="attachments.output">
            @foreach($attachments as $attachment)
                @include('attachments.item')
            @endforeach
        </div>

        <div class="pt-3">
            {{ $attachments->appends($_GET)->links() }}
        </div>
    </div>
@endsection
