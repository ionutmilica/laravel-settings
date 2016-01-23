<?php
namespace IonutMilica\LaravelSettings;

interface SettingsContract extends \ArrayAccess{

    /**
     * Get setting by key
     *
     * @param $key
     * @param null $default
     * @param bool $save
     * @return mixed
     */
    public function get($key, $default = null, $save = false);

    /**
     * Update setting
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * Forget setting
     *
     * @param $key
     */
    public function forget($key);

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
     * @return bool
     */
    public function save();

}
