<?php
namespace IonutMilica\LaravelSettings;

use IonutMilica\LaravelSettings\Drivers\Database;
use IonutMilica\LaravelSettings\Drivers\Json;
use IonutMilica\LaravelSettings\Drivers\Memory;
use Illuminate\Support\Manager;

class DriversManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config('settings.driver');
    }

    /**
     * Creates a new memory driver for settings
     *
     * @return Memory
     */
    public function createMemoryDriver()
    {
        return new Memory($this->app['config']);
    }

    /**
     * Creates a new database driver for settings
     *
     * @return Database
     */
    public function createDatabaseDriver()
    {
        return new Database($this->app['config'], $this->app['db']);
    }

    /**
     * Creates a new json driver for settings
     *
     * @return Json
     */
    public function createJsonDriver()
    {
        return new Json($this->config('settings.json_file'));
    }

    /**
     * Get config data
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->app['config']->get($key, $default);
    }

}
