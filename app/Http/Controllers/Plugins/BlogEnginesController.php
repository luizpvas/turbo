<?php

namespace App\Http\Controllers\Plugins;

use App\Models\Website;
use App\Models\Plugins\BlogEngine;
use App\Http\Controllers\Controller;

class BlogEnginesController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\Blog']);
    }

    /**
     * GET /websites/{website}/blog_engines/{blog_engine}
     * Renders the edit form
     *
     * @param  Website    $website     Current website
     * @param  BlogEngine $blog_engine Current blog engine
     * @return Illuminate\Http\Response
     */
    function edit(Website $website, BlogEngine $blog_engine)
    {
        $engine = $blog_engine;

        add_sheet(
            __('Plugins'), route('websites.plugins.index', $website)
        );

        add_sheet(
            __('Blog'), route('websites.blog_posts.index', $website)
        );

        return view('plugins.blog_engines.edit', compact('engine'));
    }

    /**
     * PUT /websites/{website}/blog_engines/{blog_engine}
     * Attempts to update the blog engine
     *
     * @param  Website    $website     Current website
     * @param  BlogEngine $blog_engine Current blog engine
     * @return Illuminate\Http\Response
     */
    function update(Website $website, BlogEngine $blog_engine)
    {
        $validatedData = request()->validate([
            'blog_post_path' => 'required',
            'posts_per_page' => 'required|numeric|max:50'
        ]);

        $blog_engine->update($validatedData);

        return js_redirect(route('websites.blog_posts.index', $website))
            ->flashSuccess(__('Settings updated with success!'));
    }
}
