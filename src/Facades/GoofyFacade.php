<?php

namespace Eduzz\Goofy\Facades;

use Eduzz\Goofy\Goofy;
use Illuminate\Support\Facades\Facade;

class GoofyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Goofy::class;
    }
}
