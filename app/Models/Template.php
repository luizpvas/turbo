<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * Disable mass assignment exceptions
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Renders this template.
     *
     * @return string
     */
    function render()
    {
        return (new Render($this->website, $this->path))->toHtml();
    }

    /**
     * A template belongs to a website.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function website()
    {
        return $this->belongsTo(Website::class);
    }
}
