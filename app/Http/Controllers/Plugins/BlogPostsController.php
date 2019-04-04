<?php

namespace App\Http\Controllers\Plugins;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Models\Plugins\BlogPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plugins\StoreBlogPostRequest;
use App\Http\Requests\Plugins\UpdateBlogPostRequest;

class BlogPostsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\Blog']);
    }

    /**
     * GET /plugins/blog_posts
     * Renders the blog posts.
     *
     * @return mixed
     */
    function index()
    {
        $posts = BlogPost::fromWebsite(website())
            ->search(request('q'))
            ->paginate(20);


        add_sheet(
            __(':website\'s plugins', ['website' => website()->name]),
            route('websites.plugins.index', website())
        );

        return view('plugins.blog_posts.index', compact('posts'));
    }

    /**
     * GET /plugins/blog_posts/create
     * Renders the new post form.
     *
     * @return mixed
     */
    function create()
    {
        $post = new BlogPost([
            'website_id' => website()->id
        ]);

        add_sheet(
            __(':website\'s plugins', ['website' => website()->name]),
            route('websites.plugins.index', website())
        );

        add_sheet(
            __('Blog posts'),
            route('websites.blog_posts.index', website())
        );

        return view('plugins.blog_posts.create', compact('post'));
    }

    /**
     * POST /plugins/blog_posts
     * Attempts to create a blog post.
     *
     * @param StoreBlogPostRequest $request HTTP request
     *
     * @return mixed
     */
    function store(StoreBlogPostRequest $request)
    {
        $blogPost = BlogPost::create(array_merge($request->validated(), [
            'website_id' => website()->id
        ]));

        return js_redirect(
            route('websites.blog_posts.edit', [website(), $blogPost])
        );
    }

    /**
     * GET /plugins/blog_posts/{id}
     * Renders the edit form.
     *
     * @param Website $website Current website
     * @param string  $id      Post id
     *
     * @return mixed
     */
    function edit(Website $website, $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('update', $post);

        add_sheet(
            __(':website\'s plugins', ['website' => website()->name]),
            route('websites.plugins.index', website())
        );

        add_sheet(
            __('Blog posts'),
            route('websites.blog_posts.index', website())
        );

        return view('plugins.blog_posts.edit', compact('post'));
    }

    /**
     * PUT /plugins/blog_posts/{id}
     * Attempts to update the blog post.
     *
     * @param UpdateBlogPostRequest $request HTTP request
     *
     * @return mixed
     */
    function update(UpdateBlogPostRequest $request)
    {
        $request->blogPost()->update($request->validated());

        return js_redirect(
            route('websites.blog_posts.edit', [website(), $request->blogPost()])
        );
    }
}
