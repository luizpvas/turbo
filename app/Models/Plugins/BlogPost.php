<?php

namespace App\Models\Plugins;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WebsiteScoped;

class BlogPost extends Model
{
    use WebsiteScoped;

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
            $post->slug = self::generateSlug($post->title);
        });

        self::updating(function ($post) {
            $post->slug = self::generateSlug($post->title);
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
     * @param  string $title Post title
     * @return void
     */
    static function generateSlug($title)
    {
        $title = strtolower($title);
        $title = str_replace('ç', 'c', $title);
        $title = str_replace('ã', 'a', $title);
        $title = str_replace('á', 'a', $title);
        $title = str_replace('é', 'a', $title);
        $title = str_replace('â', 'a', $title);
        $title = str_replace('õ', 'a', $title);
        $title = preg_replace('/[\W]+/', ' ', $title);
        $title = preg_replace('/\s{2,}/', ' ', $title);
        $title = trim($title);
        return str_replace(" ", "-", $title);
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
