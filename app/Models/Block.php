<?php

namespace App\Models;

class Block
{
    /**
     * The render instance that contains this block.
     *
     * @var Render
     */
    protected $render;

    /**
     * Raw source code of this block.
     *
     * @var string
     */
    protected $source;

    /**
     * Builds a new block from the given source code.
     *
     * @param Render $render Render instance.
     * @param string $source Source code.
     */
    function __construct($render, $source)
    {
        $this->render = $render;
        $this->source = $source;
    }

    /**
     * Returns the block of source code.
     *
     * @return string
     */
    function getSource()
    {
        return $this->source;
    }

    /**
     * Checks if this current block of code is an @at-call.
     *
     * @return boolean
     */
    function isCall()
    {
        return strpos($this->source, "@") === 0;
    }

    /**
     * Parses the given source block as an @at-call.
     *
     * @return mixed
     */
    function parseCall()
    {
        if (strpos($this->source, "@") === 0) {
            $hasParams = strpos($this->source, "(") !== false;

            if ($hasParams) {
                preg_match("/(\@([\w\-\_]+)\(([^\)]+)\))/", $this->source, $match);
            } else {
                $match = [
                    null,
                    null,
                    str_replace('@', '', $this->source),
                    ''
                ];
            }
 
            if ($match) {
                $call = $match[2];
                $params = collect(explode(",", $match[3]))->map(function ($param) {
                    return trim(trim($param, "'"), "\"");
                })->filter()->toArray();

                return [
                    'call' => $call,
                    'params' => $params
                ];
            }
        }

        return null;
    }
}
