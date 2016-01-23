<?php
namespace IonutMilica\LaravelSettings\Tests;

use IonutMilica\LaravelSettings\Drivers\Json;
use IonutMilica\LaravelSettings\SettingsContract;
use IonutMilica\LaravelSettings\SettingsImpl;

class JsonDriverTest extends TestCase
{
    /**
     * @var Json
     */
    protected $jsonDriver;

    /**
     * @var string
     */
    protected $jsonFile = '';

    /**
     * @var SettingsContract
     */
    protected $settings;

    public function setUp()
    {
        parent::setUp();

        $this->jsonFile = __DIR__.'/db.json';
        $this->jsonDriver = new Json($this->jsonFile);
        $this->settings = new SettingsImpl($this->jsonDriver, new ConfigStub());
    }

    public function tearDown()
    {
        parent::tearDown();

        if (is_file($this->jsonFile)) {
            unlink($this->jsonFile);
        }
    }

    public function test_save()
    {
        $data = ['one' => 1];
        $dirt = ['one' => ['type' => 'delete']];

        $this->jsonDriver->save($data, $dirt);


        $this->assertEquals($data, $this->jsonDriver->load());
    }

    public function test_driver_with_settings()
    {
        $this->settings->set('hello', 'world');
        $this->settings->set('test2', 'muhihi');
        $this->settings->save();

        $this->assertEquals(['hello' => 'world', 'test2' => 'muhihi'], $this->jsonDriver->load());
    }

    public function test_driver_settings_with_json()
    {
        $this->settings->set('info', ['blue', 'red', 'white']);
        $this->settings->save();

        $this->assertEquals(['info' => ['blue', 'red', 'white']], $this->jsonDriver->load());
    }
}
