<?php

namespace Tests;

require dirname(__FILE__) . '/helpers/date_helpers.php';

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
