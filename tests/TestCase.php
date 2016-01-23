<?php
namespace IonutMilica\LaravelSettings\Tests;

use Illuminate\Database\Capsule\Manager as DB;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DB
     */
    protected $db;

    public function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        $db = new DB;
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
        $db->bootEloquent();
        $db->setAsGlobal();
        $this->db = $db;
    }

}