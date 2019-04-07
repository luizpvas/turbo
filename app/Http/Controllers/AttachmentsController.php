<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website']);
    }

    /**
     * GET /websites/{website}/attachments
     * Renders the latest attachments.
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        $attachments = Attachment::fromWebsite(website())
            ->latest()
            ->paginate(16);

        return view('attachments.index', compact('attachments'));
    }

    /**
     * POST /websites/{website}/attachments
     * Stores an attachment
     *
     * @return Illuminate\Http\Response
     */
    function store()
    {
        request()->validate([
            'file' => 'required|file'
        ]);

        $path = request('file')->store('attachments', 'public');
        $url = Storage::disk('public')->url($path);

        $attachment = Attachment::create([
            'website_id' => website()->id,
            'creator_id' => auth()->id(),
            'name' => request('file')->getClientOriginalName(),
            'mime' => request('file')->getClientMimeType(),
            'size_in_bytes' => request('file')->getSize(),
            'url' => $url
        ]);

        return [
            'attachment' => $attachment,
            'item' => View::make('attachments.item', compact('attachment'))->render()
        ];
    }
}
