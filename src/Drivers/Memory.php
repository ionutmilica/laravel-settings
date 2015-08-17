<?php

namespace Bitempest\LaravelSettings\Drivers;

use Bitempest\LaravelSettings\SettingsContract;
use Illuminate\Support\Arr;

class Memory implements SettingsContract
{

    protected $data = [];

    /**
     * Get setting by key
     *
     * @param $key
     * @param null $default
     * @param bool $save
     * @return mixed
     */
    public function get($key, $default = null, $save = false)
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Update setting
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return Arr::set($this->data, $key, $value);
    }

    /**
     * Forget setting
     *
     * @param $key
     */
    public function forget($key)
    {
        Arr::forget($this->data, $key);
    }

    /**
     * Get all stored settings
     *
     * @return mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Check if setting key exists
     *
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Save dirty data into the data source
     *
     * @return mixed
     */
    public function save()
    {
        //
    }

}
