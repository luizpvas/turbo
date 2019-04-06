<?php

namespace App\Http\Controllers\Plugins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogExamplesController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\Blog']);
    }

    /**
     * GET /webistes/{website}/blog_examples
     * Renders the examples
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        add_sheet(__('Plugins'), route('websites.plugins.index', website()));
        add_sheet(__('Blog'), route('websites.blog_posts.index', website()));

        if (request('view')) {
            add_sheet(__('Examples'), route('websites.blog_examples.index', website()));
        }

        return view('plugins.blog_examples.index');
    }
}
