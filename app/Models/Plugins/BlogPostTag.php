<?php

namespace App\Models\Plugins;

use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'plugins_blog_post_tags';

    /**
     * Disable mass assignment exceptions.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Sync the tags of the post.
     *
     * @param  BlogPost $post Current blog post
     * @param  array    $tags List of tags
     * @return void
     */
    static function sync($post, $tags)
    {
        $currentTags = $post->tags()->pluck('tag');

        collect($tags)->filter(function ($tag) use ($currentTags) {
            return !$currentTags->contains($tag);
        })->map(function ($tag) use ($post) {
            return self::create([
                'blog_post_id' => $post->id,
                'tag' => $tag
            ]);
        });

        $currentTags->filter(function ($tag) use ($tags) {
            return !in_array($tag, $tags);
        })->map(function ($tag) use ($post) {
            self::where([
                'blog_post_id' => $post->id,
                'tag' => $tag
            ])->delete();
        });
    }
}
