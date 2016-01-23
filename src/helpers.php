<?php

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if ( ! function_exists('settings')) {

    /**
     * Get setting from the storage
     *
     * @param $name
     * @param $default
     * @param bool $save
     * @return \Illuminate\Foundation\Application|mixed
     */
    function settings($name = null, $default = null, $save = false)
    {
        $settings = app('IonutMilica\LaravelSettings\SettingsContract');

        if ( ! $name) {
            return $settings->all();
        }

        return $settings->get($name, $default, $save);
    }
}

if ( ! function_exists('setting')) {

    /**
     * Get setting from the storage
     *
     * @param $name
     * @param $default
     * @param bool $save
     * @return \Illuminate\Foundation\Application|mixed
     */
    function setting($name = null, $default = null, $save = false)
    {
        $setting = app('IonutMilica\LaravelSettings\SettingsContract');

        if ( ! $name) {
            return $setting->all();
        }

        return $setting->get($name, $default, $save);
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
        return app('IonutMilica\LaravelSettings\SettingsContract')
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
        return app('IonutMilica\LaravelSettings\SettingsContract')
            ->forget($name);
    }
}
