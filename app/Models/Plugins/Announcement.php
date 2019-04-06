<?php

namespace App\Models\Plugins;

use App\Models\Website;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    /**
     * Name of the table in the database
     * 
     * @var string
     */
    protected $table = 'plugins_announcements';

    /**
     * Disable mass assignment exceptions
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Cast attributes to non-string PHP types.
     * 
     * @var array
     */
    protected $casts = [
        'is_highlighted' => 'boolean'
    ];

    /**
     * Scopes a query to filter announcements belonging to a website.
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
     * Scopes a query to filter announcements belonging to a website.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query DB Query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeIsHighlighted($query)
    {
        return $query->where('is_highlighted', true);
    }

    /**
     * Resets other announcements highlighted back to false
     * if this announcement is true.
     * 
     * @param  boolean $value highlight value
     * @return void
     */
    function setIsHighlightedAttribute($value)
    {
        $isOn = !(!$value || $value === 'off');

        if ($isOn) {
            self::fromWebsite(website() ?? $this->website)
                ->when($this->id, function ($query, $id) {
                    $query->where('id', '<>', $id);
                })
                ->update(['is_highlighted' => false]);
        }

        $this->attributes['is_highlighted'] = $isOn;
    }

    /**
     * An announcement belongs to a website.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function website()
    {
        return $this->belongsTo(Website::class);
    }
}
