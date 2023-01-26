<?php

namespace Alhoqbani\Filepond\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alhoqbani\Filepond\Filepond
 */
class Filepond extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Alhoqbani\Filepond\Filepond::class;
    }
}
