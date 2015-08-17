<?php

namespace Bitempest\LaravelSettings\Drivers;

use Bitempest\LaravelSettings\SettingsContract;
use Illuminate\Support\Arr;

class Json implements SettingsContract
{

    /**
     * Settings stored locally after they are fetched
     *
     * @var array
     */
    protected $data = null;

    /**
     * @var
     */
    private $path;

    /**
     *
     *
     * @var bool
     */
    protected $isDirty = false;

    /**
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path.'/app/settings.json';
    }

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
        $this->prepare();

        if ($this->has($key)) {
            return $this->data[$key];
        }

        if ($save) {
            $this->set($key, $default);
        }

        return $default;
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
        $this->prepare();

        if ( ! $this->has($key) || $this->get($key) != $value) {
            $this->isDirty = true;
        }

        Arr::set($this->data, $key, $value);
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
     * Get all stored settings
     *
     * @return array
     */
    public function all()
    {
        $this->prepare();

        return $this->data;
    }

    /**
     * Save dirty data into the data source
     *
     * @return mixed
     */
    public function save()
    {
        if ($this->isDirty) {
            file_put_contents($this->path, json_encode($this->data));
        }
    }

    /**
     * Prepare the data for driver operations
     */
    protected function prepare()
    {
        if ($this->data !== null) {
            return;
        }

        $this->data = [];

        if (is_file($this->path)) {
            $this->data = json_decode(file_get_contents($this->path), true);
        }
    }

}
