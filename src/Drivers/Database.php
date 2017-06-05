<?php
namespace IonutMilica\LaravelSettings\Drivers;

use Illuminate\Support\Arr;
use Illuminate\Database\DatabaseManager;
use IonutMilica\LaravelSettings\DriverContract;

class Database implements DriverContract
{
    /**
     * Sql table used to store the settings
     *
     * @var string
     */
    protected $table = 'laravel_settings';

    /**
     * @var DatabaseManager
     */
    protected $database;

    /**
     * Database constructor.
     * @param DatabaseManager $database
     * @param $table
     */
    public function __construct(DatabaseManager $database, $table = null)
    {
        $this->database = $database;
        $this->table = $table ?: $this->table;
    }

    /**
     * Fetch the settings from the database
     *
     * @return array
     */
    public function load()
    {
        $data = [];

        $settings = $this->database->select('SELECT * FROM '.$this->table);

        foreach ($settings as $setting) {
            $id = $setting->id;
            $value = $setting->value;

            $decoded = json_decode($value, 1, 512);
            if (is_array($decoded)) {
                $value = $decoded;
            }

            Arr::set($data, $id, $value);
        }

        return $data;
    }

    /**
     * Save the data into the database
     * @param array $data
     * @param array $dirt
     *
     * @return bool
     */
    public function save(array $data = [], array $dirt = [])
    {
        foreach ($dirt as $field => $data) {
            switch ($data['type']) {
                case 'created':
                    $this->createSetting($field, $data['value']);
                    break;
                case 'updated':
                    $this->updateSetting($field, $data['value']);
                    break;
                case 'deleted':
                    $this->deleteSetting($field);
                    break;
            }
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

        return $this->getTableObject()->insert([
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

        return $this->getTableObject()
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
        return $this->getTableObject()
            ->where('id', $field)
            ->delete();
    }

    /**
     * Get the object for the current table
     *
     * @return mixed
     */
    private function getTableObject()
    {
        return $this->database->table($this->table);
    }

}
