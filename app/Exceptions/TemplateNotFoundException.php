<?php

namespace App\Exceptions;

use Exception;

class TemplateNotFoundException extends Exception
{
    /**
     * Builds the exception message
     *
     * @param App\Models\Website $website Current website
     * @param string             $path    URL path
     */
    function __construct($website, $path)
    {
        $message = "Could not find template [$path] in website [$website->domain]";
        parent::__construct($message);
    }
}
