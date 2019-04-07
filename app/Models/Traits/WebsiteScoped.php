<?php

namespace App\Models\Traits;

trait WebsiteScoped
{
    /**
     * Scopes a query to filter records belonging to a website.
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
     * A blog post belongs to a website.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function website()
    {
        return $this->belongsTo(\App\Models\Website::class);
    }
}
