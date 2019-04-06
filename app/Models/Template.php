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
     * Attributes that should be casted to non-string PHP types.
     *
     * @var array
     */
    protected $casts = [
        'version' => 'integer'
    ];

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
