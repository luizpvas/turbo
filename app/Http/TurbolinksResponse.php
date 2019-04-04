<?php

namespace App\Http;

use Illuminate\Contracts\Support\Responsable;

class TurbolinksResponse implements Responsable
{
    protected $redirect;
    protected $redirectAction;
    protected $flash;

    /**
     * Builds the turbolinks response for a redirect.
     *
     * @param string $redirect Route name
     * @param string $action   Advance or replace
     */
    function __construct($redirect, $action = 'advance')
    {
        $this->redirect = $redirect;
        $this->redirectAction = $action;
        $this->flash = [];
    }

    /**
     * Appends the flash message to the response.
     *
     * @param string $message Message to display.
     *
     * @return TurbolinksResponse
     */
    function flashSuccess($message)
    {
        $this->flash['success'] = $message;

        return $this;
    }

    /**
     * Appends the flash message to the response.
     *
     * @param string $message Message to display.
     *
     * @return TurbolinksResponse
     */
    function flashError($message)
    {
        $this->flash['error'] = $message;

        return $this;
    }

    /**
     * Converts response to JSON.
     *
     * @return Illuminate\Http\Response
     */
    function toResponse($request)
    {
        $json['redirect'] = $this->redirect;
        $json['flash'] = $this->flash;

        return response()->json($json);
    }
}
