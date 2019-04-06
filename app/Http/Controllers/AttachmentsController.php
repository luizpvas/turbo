<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
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
     * POST /websites/{website}/attachments
     * Stores an attachment
     *
     * @return Illuminate\Http\Response
     */
    function store()
    {
        $path = request('file')->store('attachments', 'public');
        $url = Storage::disk('public')->url($path);

        return Attachment::create([
            'website_id' => website()->id,
            'user_id' => auth()->id(),
            'name' => request('file')->getClientOriginalName(),
            'mime' => request('file')->getClientMimeType(),
            'size_in_bytes' => request('file')->getSize(),
            'url' => $url
        ]);
    }
}
