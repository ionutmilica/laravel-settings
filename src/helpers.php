<?php

if ( ! function_exists('setting')) {

    /**
     * Get setting from the storage
     *
     * @param $name
     * @param $default
     * @return \Illuminate\Foundation\Application|mixed
     */
    function setting($name = null, $default = null)
    {
        $setting = app('Bitempest\LaravelSettings\SettingsContract');

        if ( ! $name) {
            return $setting->all();
        }

        return $setting->get($name, $default);
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

if ( ! function_exists('setting_forget')) {

    /**
     * Forget a setting
     *
     * @param $name
     * @return \Illuminate\Foundation\Application|mixed
     */
    function setting_forget($name)
    {
        return app('Bitempest\LaravelSettings\SettingsContract')
            ->forget($name);
    }
}
