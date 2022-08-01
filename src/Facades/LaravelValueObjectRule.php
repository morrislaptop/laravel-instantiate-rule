<?php

namespace Morrislaptop\LaravelValueObjectRule\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Morrislaptop\LaravelValueObjectRule\LaravelValueObjectRule
 */
class LaravelValueObjectRule extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Morrislaptop\LaravelValueObjectRule\LaravelValueObjectRule::class;
    }
}
