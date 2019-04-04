<?php

namespace App\Plugins;

use App\Models\Plugins\BlogPost;

class Blog implements Plugin
{
    /**
     * Returns the plugin name, localized to the current
     * user.
     *
     * @return string
     */
    function name()
    {
        return __('Blog engine');
    }

    /**
     * Returns the plugin description, localized to the
     * current user.
     *
     * @return string
     */
    function description()
    {
        return __('Posts, tags, comments. The usual thing you expect from a blog.');
    }

    /**
     * Returns the root path to manage this plugin.
     *
     * @param  App\Models\Website $website Current website.
     * @return string
     */
    function rootPath($website)
    {
        return route('websites.blog_posts.index', $website);
    }

    /**
     * Maybe runs the given at-call.
     *
     * @param  mixed             $call   Parsed at-call.
     * @param  App\Models\Render $render Render instance.
     * @return mixed
     */
    function runCall($call, $render)
    {
        switch($call['call']) {
        case 'blog-post-title':
            return $this->getPostFromHttpRequest()->title;
        case 'blog-post-body':
            return $this->getPostFromHttpRequest()->body_html;
        case 'blog-post-tags':
            return 'Blog post tags';
        case 'blog-post-related':
            return 'Blog post related';
        default:
            return null;
        }
    }

    /**
     * Fetches the blog post record from the request.
     *
     * @return App\Models\Plugins\BlogPost
     */
    function getPostFromHttpRequest()
    {
        if ($post = request()->get('post')) {
            return $post;
        }

        $parts = explode("/", request()->path);
        $slug = $parts[count($parts) - 1];

        $post = BlogPost::fromWebsite(website())
            ->where('slug', $slug)
            ->first();

        request()->attributes->set('post', $post);

        return $post;
    }
}
