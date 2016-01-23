<?php
namespace IonutMilica\LaravelSettings;

interface DriverContract
{

    /**
     * Load the settings from the data storage
     *
     * @return array
     */
    public function load();

    /**
     * Save settings into the data storage: memory, json, db, ...
     *
     * @param array $settings
     * @param array $dirt
     * @return mixed
     */
    public function save(array $settings = [], array $dirt = []);
}
