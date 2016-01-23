<?php

namespace IonutMilica\LaravelSettings;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{

    /**
     * Get facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }

}
