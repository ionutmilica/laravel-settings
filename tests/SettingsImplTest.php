<?php
namespace IonutMilica\LaravelSettings\Tests;

use Illuminate\Contracts\Config\Repository;
use IonutMilica\LaravelSettings\Drivers\Memory;
use IonutMilica\LaravelSettings\SettingsContract;
use IonutMilica\LaravelSettings\SettingsImpl;

class SettingsImplTest extends TestCase
{
    /**
     * @var SettingsContract
     */
    protected $settings;

    public function setUp()
    {
        parent::setUp();

        $this->settings = new SettingsImpl(new Memory(), new ConfigStub());
    }

    public function test_set_setting()
    {
        $this->settings->set('ionut', 'milica');
        $this->settings->set('first.second', 33);
        $this->settings->set('first.third', 44);

        $this->assertEquals('milica', $this->settings->get('ionut', null));
        $this->assertEquals(33, $this->settings->get('first.second'));
        $this->assertEquals(44, $this->settings->get('first.third'));

        $this->assertEquals(['second' => 33, 'third' => 44], $this->settings->get('first'));

        // Test not found setting and not found with default
        $this->assertEquals(null, $this->settings->get('first.third.forth'));
        $this->assertEquals('default', $this->settings->get('first.third.forth', 'default'));
    }

    public function test_set_with_array()
    {
        $this->settings->set('info', ['blue', '30cm', 'green']);

        $this->assertEquals(['blue', '30cm', 'green'], $this->settings->get('info'));
    }

    public function test_get_with_save()
    {
        // Get should not save by default
        $this->settings->get('test.x', 22);
        $this->assertEquals(null, $this->settings->get('test'));

        $this->settings->get('general.on', false, true);
        $this->assertEquals(['on' => false], $this->settings->get('general'));
    }

    public function test_forgot_setting()
    {
        $this->settings->set('hello', 'world');
        $this->settings->set('goodbye', 'hello');

        $this->settings->forget('hello');

        $this->assertEquals(null, $this->settings->get('hello'));

        //
        $this->settings->set('one.two', 2);
        $this->settings->set('one.three', 3);
        $this->settings->forget('one.three');
        $this->assertEquals(['two' => 2], $this->settings->get('one'));

    }

    public function test_has_setting()
    {
        $this->settings->set('hello', 'world');

        $this->assertEquals(true, $this->settings->has('hello'));
        $this->assertEquals(false, $this->settings->has('world'));

    }

    public function test_all_settings()
    {
        $this->settings->set('one', 1);
        $this->settings->set('two', 2);
        $this->settings->set('1.2', 12);

        $this->assertEquals(['one' => 1, 'two' => 2, 1 => [2 => 12]], $this->settings->all());
    }

    public function test_array_access_set()
    {
        $this->settings['hello'] = 'world';

        $this->assertEquals('world', $this->settings->get('hello'));
    }

}
