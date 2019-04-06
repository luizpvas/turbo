<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\Router;
use App\Models\Traits\HasPlugins;
use Illuminate\Filesystem\Filesystem;
use App\Models\Traits\TemplateRenderer;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasPlugins, Router, TemplateRenderer;

    /**
     * Disable mass-assignment protection.
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
     * Registers the event callbacks.
     *
     * @return void
     */
    static function boot()
    {
        parent::boot();

        self::creating(function ($website) {
            $website->private_key = Str::random(40);
        });
    }

    /**
     * Finds a website by domain or subomdain
     *
     * @param string $host Website host
     *
     * @return Website
     */
    static function findByHost($host)
    {
        if ($website = self::where('domain', $host)->first()) {
            return $website;
        }

        $parts = explode(".", $host);
        $subdomain = $parts[0];
        $appDomain = str_replace($parts[0] . ".", "", $host);

        if (config('app.host') == $appDomain) {
            return self::where('subdomain', $subdomain)->first();
        }
    }

    /**
     * Attempts to find the website record by the private key.
     *
     * @param  string $key private key.
     * @return Website
     */
    static function findOrFailByKey($key)
    {
        return self::where('private_key', $key)->firstOrFail();
    }

    /**
     * Scopes a query to filter websites the user is authorized
     * to visit.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query DB Query
     * @param User                                  $user  Current user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeAuthorized($query, $user)
    {
        return $query->where('owner_id', $user->id);
    }

    /**
     * Checks if the given user is the owner of this website.
     *
     * @param User $user Current user
     *
     * @return boolean
     */
    function isOwner($user)
    {
        return $this->owner_id == $user->id;
    }

    /**
     * Generates a link to the website from the route's name.
     *
     * @param  string $route Path
     * @return string
     */
    function route($route)
    {
        $port = config('app.port');
        $port = $port == '80' ? '' : ':' . $port;

        return sprintf("http://%s.%s%s%s",
            $this->subdomain,
            config('app.host'),
            $port,
            $route
        );
    }

    /**
     * Creates a new version of the templates from the files
     * in the given directory.
     *
     * @param  string $dir Directory path
     * @return void
     */
    function publishTemplatesFromDirectory($dir)
    {
        if (!is_dir($dir)) {
            throw new \Exception("directory not found: " . $dir);
        }

        $version = $this->templates_version + 1;

        $this->update(['templates_version' => $version]);

        $deployment = $this->deployments()->create(['templates_version' => $version]);

        $files = (new Filesystem())->allFiles($dir);
        foreach ($files as $file) {
            $html = file_get_contents($file->getPathname());
            $this->templates()->create([
                'deployment_id' => $deployment->id,
                'version' => $version,
                'path' => str_replace($dir, "", $file->getPathname()),
                'html' => $html
            ]);
        }

        return $deployment;
    }

    /**
     * A website belongs to the website owner (user).
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * A website has many templates.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function templates()
    {
        return $this->hasMany(Template::class);
    }


    /**
     * Filters the templates to the current version.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function currentTemplates()
    {
        return $this->templates()
            ->where('version', $this->templates_version);
    }

    /**
     * A website has many deployments instances.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function deployments()
    {
        return $this->hasMany(Deployment::class);
    }
}
