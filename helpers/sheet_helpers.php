<?php

/**
 * Appends a sheet to the stack.
 *
 * @param  string $label Sheet label
 * @param  string $route Sheet route
 * @return void
 */
function add_sheet($label, $route)
{
    global $_sheets;

    $_sheets[] = ['label' => $label, 'route' => $route];
}

/**
 * Returns the list of sheeets, in order they were stacked.
 *
 * @return array
 */
function sheets()
{
    global $_sheets;
    return $_sheets ?? [];
}
