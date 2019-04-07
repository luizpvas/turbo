<?php

function travel_to($date)
{
    \Carbon\Carbon::setTestNow($date);
}
