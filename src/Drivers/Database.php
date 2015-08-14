<?php

namespace Bitempest\LaravelSettings\Drivers;


use Bitempest\LaravelSettings\Contracts\SettingsContract;
use Illuminate\Database\DatabaseManager;

class Database implements SettingsContract
{

    const table = 'laravel_settings';

    /**
     * Settings data from database
     *
     * @var array
     */
    protected $data = null;

    /**
     * Settings that should be created
     *
     * @var array
     */
    protected $create = [];

    /**
     * Settings that should be updated
     *
     * @var array
     */
    protected $update = [];

    /**
     * @var DatabaseManager
     */
    private $database;

    /**
     * @param DatabaseManager $database
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Get setting by key
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->data[$key];
        }

        return $default;
    }

    /**
     * Update setting
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->prepare();

        if ( ! $this->has($key)) {
            $this->create[$key] = $value;
        }

        if ( ! $this->has($key) || $this->get($key) != $value) {
            $this->update[$key] = $value;
        }

        $this->data[$key] = $value;
    }

    /**
     * Check if setting key exists
     *
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        $this->prepare();

        return isset($this->data[$key]);
    }

    /**
     * Get all stored settings
     *
     * @return mixed
     */
    public function all()
    {
        $this->prepare();

        return $this->data;
    }

    /**
     * Fetch the data if its not already fetched from the database
     */
    protected function prepare()
    {
        if ( ! is_null($this->data)) {
            return;
        }

        $this->data = [];

        $settings = $this->database->select('SELECT * FROM '.self::table);

        foreach ($settings as $setting) {
            $this->data[$setting->id] = $setting->value;
        }
    }

    /**
     * Save the data into the database
     */
    public function save()
    {
        foreach ($this->create as $field => $value) {
            $this->createSetting($field, $value);
        }

        foreach ($this->update as $field => $value) {
            $this->updateSetting($field, $value);
        }
    }

    /**
     * Create setting
     *
     * @param $field
     * @param $value
     */
    protected function createSetting($field, $value)
    {
        return $this->database->table(self::table)->insert([
            'id' => $field,
            'value' => $value
        ]);
    }

    /**
     * Update setting
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    protected function updateSetting($field, $value)
    {
        return $this->database->table(self::table)
            ->where('id', $field)
            ->update(['value' => $value]);
    }
}
