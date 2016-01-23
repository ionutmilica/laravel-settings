<?php
namespace IonutMilica\LaravelSettings\Drivers;

use IonutMilica\LaravelSettings\DriverContract;

class Json implements DriverContract
{
    /**
     * @var
     */
    protected $filePath;

    /**
     * Json constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Save dirty data into the data source
     *
     * @param array $data
     * @param array $dirt
     *
     * @return bool
     */
    public function save(array $data = [], array $dirt = [])
    {
        if ($dirt != null) {
            file_put_contents($this->filePath, json_encode($data));
            return true;
        }

        return false;
    }

    /**
     * Prepare the data for driver operations
     */
    public function load()
    {
        $data = [];

        if (is_file($this->filePath)) {
            $data = json_decode(file_get_contents($this->filePath), true);
        }

        return $data;
    }

}
