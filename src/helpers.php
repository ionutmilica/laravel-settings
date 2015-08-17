<?php

if ( ! function_exists('setting')) {

    /**
     * Get setting from the storage
     *
     * @param $name
     * @param $default
     * @return \Illuminate\Foundation\Application|mixed
     */
    function setting($name, $default = null)
    {
        return app('Bitempest\LaravelSettings\SettingsContract')->get($name, $default);
    }
}

if ( ! function_exists('setting_set')) {

    /**
     * Create or update a new setting
     *
     * @param $name
     * @param $value
     * @return \Illuminate\Foundation\Application|mixed
     */
    function setting_set($name, $value)
    {
        return app('Bitempest\LaravelSettings\SettingsContract')
                ->set($name, $value);
    }
}
