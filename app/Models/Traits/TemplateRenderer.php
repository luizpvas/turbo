<?php

namespace App\Models\Traits;

use App\Models\Render;

trait TemplateRenderer
{
    /**
     * Renders teh template.
     *
     * @param  string $path Path to the template.
     * @return string
     */
    function renderTemplate($path)
    {
        return (new Render($this, $path))->toHtml();
    }

    /**
     * Similar to `renderTemplate`, but the produced output is
     * eval'ed as PHP code.
     *
     * @param  string $path Path to the template.
     * @return string
     */
    function evalTemplate($path)
    {
        return (new Render($this, $path))->evalHtml();
    }
}
