<?php

namespace App\Models\Plugins;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    /**
     * Name of the database table.
     * 
     * @var string
     */
    protected $table = 'plugins_blog_posts';

    /**
     * Prevent mass-assignment exceptions
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Attributes that should be casted to non-string PHP types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime'
    ];

    /**
     * Registers event callback
     *
     * @return void
     */
    static function boot()
    {
        parent::boot();

        self::creating(function ($post) {
            $post->slug = $post->generateSlugFromTitle();
        });
    }

    /**
     * Scopes a query to filter blog posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query DB Query
     * @param string                                $q     Query filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeSearch($query, $q)
    {
        if (!$q) {
            return $query;
        }

        return $query->where('title', 'like', "%$q%");
    }

    /**
     * Scopes a query to filter blog posts belonging to a website.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query   DB Query
     * @param Website                               $website Current website
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeFromWebsite($query, $website)
    {
        return $query->where('website_id', $website->id);
    }

    /**
     * Checks if the post is published.
     *
     * @return boolean
     */
    function isPublished()
    {
        return !is_null($this->published_at);
    }

    /**
     * Generates a slug from the title
     *
     * @return void
     */
    function generateSlugFromTitle()
    {
        return str_replace(" ", "-", strtolower($this->title));
    }

    /**
     * A blog post belongs to a website.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function website()
    {
        return $this->belongsTo(\App\Models\Website::class);
    }

    /**
     * A blog post is written by an author.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * A post has many tags
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function tags()
    {
        return $this->hasMany(BlogPostTag::class);
    }
}
