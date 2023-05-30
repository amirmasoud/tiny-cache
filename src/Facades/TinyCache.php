<?php

namespace Amirmasoud\TinyCache\Facades;

use Illuminate\Support\Facades\Facade;

class TinyCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Amirmasoud\TinyCache\TinyCache::class;
    }
}
