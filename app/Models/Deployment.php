<?php

namespace App\Models;

use App\Models\Traits\WebsiteScoped;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use WebsiteScoped;

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
     * A deployment is associated with many templates of the current version.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function templates()
    {
        return $this->hasMany(Template::class);
    }
}
