<?php

return [
    /**
     * Settings driver is used for storage
     *
     * memory - settings are erased on the end of the request
     * database - settings are persisted into a database
     * json - settings are persisted into json file
     */

    'driver' => 'json',

    /**
     * This option let us to fallback to the laravel config options
     * if the option does not exist
     *
     */

    'fallback' => true,
];
