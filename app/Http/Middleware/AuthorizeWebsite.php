<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Website;

class AuthorizeWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request HTTP request
     * @param \Closure                 $next    Closure
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route('website') instanceof Website) {
            $website = $request->route('website');
        } else {
            $website = Website::findOrFail($request->route('website'));
        }

        $request->attributes->set('website', $website);

        if ($request->user()->can('update', $website)) {
            return $next($request);
        } else {
            $message = __("Sorry, you don't have access to :website_name", [
                'website_name' => $website->name
            ]);

            abort(403, $message);
        }
    }
}
