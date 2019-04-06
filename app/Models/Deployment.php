<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    /**
     * Disable mass assignment exceptions.
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
        'templates_version' => 'integer'
    ];

    /**
     * Scopes a query to filter deployments belonging to a website.
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
     * A deployment is associated with many templates of the current version.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function templates()
    {
        return $this->hasMany(Template::class);
    }
}
