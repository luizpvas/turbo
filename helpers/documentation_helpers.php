<?php

/**
 * Renders an example template.
 *
 * @param  string $file file path
 * @param  array  $opts Render options
 * @return string
 */
function render_example($file, $opts = [])
{
    $html = file_get_contents($file);

    foreach ($opts as $key => $val) {
        $html = str_replace('%' . $key . '%', $val, $html);
    }

    return $html;
}
