<?php

namespace Bitempest\LaravelSettings\Drivers;


use Bitempest\LaravelSettings\SettingsContract;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
    protected $created = [];

    /**
     * Settings that should be updated
     *
     * @var array
     */
    protected $updated = [];

    /**
     * Deleted setting that should be removed from the database
     *
     * @var array
     */
    protected $deleted = [];

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
     * @param bool $save
     * @return mixed
     */
    public function get($key, $default = null, $save = false)
    {
        if ($this->has($key)) {
            return Arr::get($this->data, $key);
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
     */
    public function set($key, $value)
    {
        $this->prepare();

        if ( ! $this->has($key)) {
            $this->created[$key] = $value;
        }

        if ($this->has($key) && $this->get($key) != $value) {
            $this->updated[$key] = $value;
        }

        Arr::set($this->data, $key, $value);
    }

    /**
     * Remove setting from the database
     *
     * @param $key
     */
    public function forget($key)
    {
        $this->prepare();

        if ($this->has($key)) {
            Arr::forget($this->data, $key);
            $this->deleted[$key] = null;
        }
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

        return Arr::has($this->data, $key);
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
            $value = $setting->value;

            if (Str::startsWith($value, '[') || Str::startsWith($value, '{' )) {
                $value = json_decode($value, 1, 512);
            }

            Arr::set($this->data, $setting->id, $value);
        }
    }

    /**
     * Save the data into the database
     */
    public function save()
    {
        foreach ($this->created as $field => $value) {
            $this->createSetting($field, $value);
        }

        foreach ($this->updated as $field => $value) {
            $this->updateSetting($field, $value);
        }

        foreach ($this->deleted as $field => $value) {
            $this->deleteSetting($field);
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
        $value = is_array($value) ? json_encode($value) : $value;

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
        $value = is_array($value) ? json_encode($value) : $value;

        return $this->database->table(self::table)
            ->where('id', $field)
            ->update(['value' => $value]);
    }

    /**
     * Delete setting from the database
     *
     * @param $field
     * @return mixed
     */
    public function deleteSetting($field)
    {
        return $this->database->table(self::table)
            ->where('id', $field)
            ->delete();
    }

}
