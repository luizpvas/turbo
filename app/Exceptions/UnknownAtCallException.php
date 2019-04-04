<?php

namespace App\Exceptions;

use Exception;

class UnknownAtCallException extends Exception
{
    function __construct($call)
    {
        $message = "Unknown at-call: @" . $call['call'];
        parent::__construct($message);
    }
}
