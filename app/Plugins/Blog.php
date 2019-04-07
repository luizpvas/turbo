<?php

namespace App\Plugins;

use App\Models\Plugins\BlogPost;
use App\Models\Plugins\BlogEngine;

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
     * Callback called when the plugin is enabled.
     *
     * @param  App\Models\Website $website Current website
     * @return void
     */
    function enable($website)
    {
        if (is_null(BlogEngine::defaultForWebsite($website))) {
            BlogEngine::create([
                'website_id' => $website->id
            ]);
        }
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
        case 'blog-posts-paginated-list':
            $render->peek('end-blog-posts-paginated-list');
            return '<?php foreach(\App\Plugins\Blog::paginatedPosts() as $item) { ?>';
        case 'end-blog-posts-paginated-list':
            return '<?php } ?>';
        case 'blog-posts-latest':
            $render->peek('end-blog-posts-latest');
            return '<?php foreach(\App\Plugins\Blog::latestPosts('.$call['params'][0].') as $item) { ?>';
        case 'end-blog-posts-latest':
            return '<?php } ?>';
        case 'blog-post-list-item-title':
            return '<?= $item->title ?>';
        case 'blog-post-list-item-published-at':
            return '<?= $item->published_at->diffForHumans() ?>';
        case 'blog-post-list-item-url':
            return '<?= \App\Plugins\Blog::postUrl($item) ?>';
        case 'blog-post-list-item-tags':
            return '<?= \App\Plugins\Blog::renderTags($item->tags) ?>';
        case 'blog-post-list-item-author-name':
            return '<?= $item->author->name ?>';
        case 'blog-post-title':
            return '<?= \App\Plugins\Blog::getPostFromRequest("title") ?>';
        case 'blog-post-body':
            return '<?= \App\Plugins\Blog::getPostFromRequest("body_html") ?>';
        case 'blog-post-tags':
            return '<?= \App\Plugins\Blog::renderTags(\App\Plugins\Blog::getPostFromRequest()->tags) ?>';
        case 'blog-post-author-name':
            return '<?= \App\Plugins\Blog::getPostFromRequest()->author->name ?>';
        case 'blog-post-published-at':
            return '<?= \App\Plugins\Blog::getPostFromRequest("published_at")->diffForHumans() ?>';
        case 'blog-post-related':
            return 'Blog post related';
        default:
            return null;
        }
    }

    static function postUrl($item)
    {
        $engine = BlogEngine::defaultForWebsite(website());

        if ($engine) {
            return $engine->blog_post_path . '/' . $item->slug;
        }

        throw new \Exception('Could find BlogEngine record for this website.');
    }

    /**
     * Renders the list of tags as HTML templates.
     *
     * @param  array $tags List of tags
     * @return string
     */
    static function renderTags($tags)
    {
        return $tags->map(function ($tag) {
            return '<div class="inline-block bg-indigo text-white rounded font-bold text-xs py-px px-1 mr-1">' . $tag->tag . '</div>';
        })->implode("");
    }

    /**
     * Paginates the latest blog posts for this website.
     *
     * @return mixed
     */
    static function paginatedPosts()
    {
        return BlogPost::fromWebsite(website())
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
    }

    /**
     * Fetches the n latest posts.
     *
     * @param  integer $n Amount of posts
     * @return mixed
     */
    static function latestPosts($n = 3)
    {
        $n = min($n, 10);

        return BlogPost::fromWebsite(website())
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->take($n)
            ->get();
    }

    /**
     * Fetches the blog post record from the request.
     *
     * @param  string|null $attr Attribute of the post
     * @return App\Models\Plugins\BlogPost
     */
    static function getPostFromRequest($attr = null)
    {
        if ($post = request()->get('post')) {
            return is_null($attr) ? $post : ($post->$attr ?? '');
        }

        $parts = explode("/", request()->path);
        $slug = $parts[count($parts) - 1];

        $post = BlogPost::fromWebsite(website())
            ->where('slug', $slug)
            ->first();

        request()->attributes->set('post', $post);

        return is_null($attr) ? $post : ($post->$attr ?? '');
    }
}
