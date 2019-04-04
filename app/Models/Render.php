<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Render
{
    /**
     * Rendered template.
     *
     * @var string
     */
    protected $html;

    /**
     * Raw template, as read from disk.
     *
     * @var string
     */
    protected $template;

    /**
     * The layout this template is rendered on.
     *
     * @var string
     */
    protected $layout;

    /**
     * Builds the renderer.
     *
     * @param App\Models\Website $website Current website
     * @param string             $path    Template path
     */
    function __construct($website, $path)
    {
        $this->website = $website;
        $this->path = $path;
        $this->html = '';
        $this->layout = '$$$default$$$';
        $this->template = $website->routeTemplate($path);
        $this->currentSection = 'default';
        $this->sections = [];
        $this->splitBlocks = [];
        $this->index = 0;
    }

    /**
     * Returns the compiled HTML.
     *
     * @return string
     */
    function toHtml()
    {
        $this->splitByAtCalls();

        while ($block = $this->next()) {
            if ($block->isCall()) {
                $this->runCall($block->parseCall());
            } else {
                $this->appendHtml($block->getSource());
            }
        }

        $rendered = $this->layout;

        foreach ($this->sections as $section => $html) {
            $rendered = str_replace("$$$$section$$$", $html, $rendered);
        }

        return $rendered;
    }

    /**
     * Process the output with `toHtml`, but evaluates the result as PHP code.
     *
     * @return string
     */
    function evalHtml()
    {
        ob_start();

        try {
            eval('?>' . $this->toHtml());
        } catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    /**
     * Iterates through the splitted block calls.
     * 
     * @return mixed
     */
    function next()
    {
        if (isset($this->splitBlocks[$this->index])) {
            $block = $this->splitBlocks[$this->index];
            $this->advance();
            return new Block($this, $block);
        }
    }

    /**
     * Advances the index pointer.
     *
     * @return void
     */
    function advance()
    {
        $this->index += 1;
    }

    /**
     * Ensures the given $call appears in the template after the current
     * index. Useful for blocks with and 'end' call.
     *
     * @param  string $call Name of the call
     * @return void
     */
    function peek($call)
    {
        for ($i = $this->index; $i < count($this->splitBlocks); $i++) {
            if (strpos($this->splitBlocks[$i], '@' . $call) === 0) {
                return;
            }
        }

        throw new \App\Exceptions\CallNotFoundException($call);
    }

    /**
     * Runs the call parsed from the template source code.
     *
     * @param  mixed $call Parsed at call
     * @return void
     */
    protected function runCall($call)
    {
        switch($call['call']) {
        case 'layout':
            $this->layout = (new Render($this->website, $call['params'][0]))->toHtml();
            break;
        case 'yield':
            $this->appendHtml('$$$' . $call['params'][0] . '$$$');
            break;
        case 'section':
            $this->changeSection($call['params'][0]);
            break;
        case 'include':
            $this->appendHtml((new Render($this->website, $call['params'][0]))->toHtml());
            break;
        default:
            $this->appendHtml(\App\Plugins\Kernel::runCall($call, $this));
            break;
        }
    }

    /**
     * Change the current section to the specified one.
     *
     * @param  string $section Section name
     * @return void
     */
    protected function changeSection($section)
    {
        $this->currentSection = $section;
    }

    /**
     * Appends the given html to the current section.
     *
     * @param  string $html HTML to append
     * @return void
     */
    protected function appendHtml($html)
    {
        if (isset($this->sections[$this->currentSection])) {
            $this->sections[$this->currentSection] .= $html;
        } else {
            $this->sections[$this->currentSection] = $html;
        }
    }

    /**
     * Splits the template at each @at-call.
     *
     * @return array
     */
    protected function splitByAtCalls()
    {
        $flags = PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY;
        $this->splitBlocks = collect(
            preg_split("/(\@\w+\([^\)]+\))|(\@[\w\-\_]+)/", $this->template, -1, $flags)
        );
    }
}
