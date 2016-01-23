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
     * Sql table used to store the settings
     * Take note that it's used only when `database` driver is selected
     */
    'table' => 'laravel_settings',


    /**
     * Json file used to store the settings
     * Take note that it's used only when `json` driver is selected
     */
    'json_file' => storage_path('app/settings.json'),

    /**
     * This option let us to fallback to the laravel config options
     * if the option does not exist
     */

    'fallback' => true,
];
