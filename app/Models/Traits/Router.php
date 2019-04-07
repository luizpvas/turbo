<?php

namespace App\Models\Traits;

use Illuminate\Filesystem\Filesystem;
use App\Exceptions\TemplateNotFoundException;

trait Router
{
    /**
     * Reads the template from the given path.
     *
     * @param  string $path Path to the template
     * @return string|null
     */
    function routeTemplate($path)
    {
        try {
            try {
                return $this->readTemplate($path);
            } catch(\Exception $e) {
                if ($this->hasMoreThanOnePathPart($path)) {
                    return $this->readTemplate($this->removeLatestPathPart($path));
                }

                throw $e;
            }
        } catch(\Exception $e) {
            throw new TemplateNotFoundException($this, $path);
        }
    }

    /**
     * Reads the template from the disk.
     *
     * @param  string $path Template path
     * @return string
     */
    function readTemplate($path)
    {
        $path = $this->normalizeRoute($path);

        return $this->currentTemplates()
            ->where('path', $path)
            ->first()
            ->html;
    }

    /**
     * Normalizes the route.
     *
     * @param  string $route Route path
     * @return string
     */
    function normalizeRoute($route)
    {
        if ($route === '' || $route === '/') {
            return '/index.html';
        }

        $route = str_replace(".html", "", $route) . ".html";

        if (strpos($route, "/") === 0) {
            return $route;
        }

        return "/" . $route;
    }

    /**
     * Checks if the path has at least two parts.
     * For exmaple, /one/two.
     *
     * @param  string $path URL path
     * @return boolean
     */
    function hasMoreThanOnePathPart($path)
    {
        return substr_count($path, '/') >= 2;
    }

    /**
     * Removes the latest part of the path.
     * Example: "/foo/bar/baz" => "/foo/bar"
     *
     * @param  string $route URL path
     * @return string
     */
    function removeLatestPathPart($route)
    {
        $parts = explode("/", $route);
        array_pop($parts);
        return implode("/", $parts);
    }
}
