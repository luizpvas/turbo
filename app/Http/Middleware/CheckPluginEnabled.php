<?php

namespace App\Http\Middleware;

use Closure;

class CheckPluginEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request    HTTP request
     * @param \Closure                 $next       Closure
     * @param string                   $pluginName Name of the plugin
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $pluginName)
    {
        if (website() && website()->hasPlugin($pluginName)) {
            return $next($request);
        } else {
            $message = __('Desculpe, o website não tem acesso ao plugin :plugin_name', [
                'plugin_name' => $pluginName
            ]);

            abort(403, $message);
        }
    }
}
