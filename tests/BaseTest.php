<?php

namespace Eduzz\Goofy\Tests;

use PHPUnit\Framework\TestCase;
use Mockery as M;

class BaseTest extends TestCase
{

    public function teardown()
    {
        M::close();
    }
}