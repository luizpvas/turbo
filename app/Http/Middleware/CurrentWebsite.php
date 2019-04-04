<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Website;

class CurrentWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request HTTP request
     * @param \Closure                 $next    Callback
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $website = Website::findByHost($request->getHost());
        $request->attributes->set('website', $website);

        return $next($request);
    }
}
