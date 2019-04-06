@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1>@lang('Deployments history')</h1>
    </div>

    <div class="p-4">
        @forelse($deployments as $deployment)
            <div class="mb-2">
                <div class="font-bold">@lang('Deployment #:id', ['id' => $deployment->templates_version])</div>
                <div class="text-sm italic text-grey-darker">@lang('Published :time', ['time' => $deployment->created_at->diffForHumans()])</div>
                @foreach($deployment->templates as $template)
                    <div class="inline-block font-mono text-xs bg-grey-lighter">{{ $template->path }}</div>
                @endforeach
            </div>
        @empty
            <div class="text-center text-green-dark mt-8 italic">
                @lang("Everything is ready for your first deployment!")
            </div>
        @endforelse
    </div>

    <div class="p-6 text-grey-darkest">
        <h1>@lang('How to publish new code?')</h1>

        <ol class="mt-4">
            <li>
                Install the <code>turbo</code> command line interface. It's currently only available for <a href="#">linux</a>.
            </li>
            <li>
                Add a <code>.turbokey</code> file to the root of your project with this website's private key.
                The private key should be kept safe, so don't forget to add this file to your <code>.gitignore</code>.
                <div class="bg-grey-lighter p-2 my-2">
                    {{ website()->name }}'s private key key is:
                    <input class="border border-yellow text-yellow-darker text-xs p-1 w-64" value="{{ website()->private_key }}" readonly>
                    <div class="text-sm italic">
                        You shouldn't share it with anyone, but if it ever gets leaked you can genereate a new one <a href="#">here</a>.
                    </div>
                </div>
            </li>
            <li>
                Run <code>turbo deploy</code> from your project's root directory.
            </li>
        </ol>
    </div>
@endsection
