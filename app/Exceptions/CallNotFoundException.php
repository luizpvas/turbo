<?php

namespace App\Exceptions;

use Exception;

class CallNotFoundException extends Exception
{
    /**
     * Builds the exception message
     *
     * @param string $call At call
     */
    function __construct($call)
    {
        $message = "Expected @$call to be in the template.";
        parent::__construct($message);
    }
}
