<?php

namespace Bitempest\LaravelSettings\Contracts;

interface SettingsContract {

    /**
     * Get setting by key
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Update setting
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value);

    /**
     * Check if setting key exists
     *
     * @param $key
     * @return mixed
     */
    public function has($key);

    /**
     * Get all stored settings
     *
     * @return mixed
     */
    public function all();

    /**
     * Save dirty data into the data source
     *
     * @return mixed
     */
    public function save();

}
