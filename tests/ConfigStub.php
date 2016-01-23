<?php
/*
* This file is part of the Smile Media Project.
*
* (c) Ionut Catalin Milica <ionut.milica@gmail.com>
* (c) Alex Mihai Andonie <andoniealex@gmail.com>
*
* You are not allowed to redistribute those files
* unless you buy one Extended License per Client.
*
*/

namespace IonutMilica\LaravelSettings\Tests;

use Illuminate\Contracts\Config\Repository;

class ConfigStub implements Repository {

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Get the specified configuration value.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string $key
     * @param  mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        // TODO: Implement set() method.
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function prepend($key, $value)
    {
        // TODO: Implement prepend() method.
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function push($key, $value)
    {
        // TODO: Implement push() method.
    }
}