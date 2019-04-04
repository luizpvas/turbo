<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['website']);
    }

    /**
     * GET /{path}
     * Renders a template.
     *
     * @param string $domain Website's domain
     * @param string $path   Request path
     *
     * @return Illuminate\Http\Response
     */
    function index($domain, $path)
    {
        return request()->get('website')->evalTemplate($path);
    }
}
