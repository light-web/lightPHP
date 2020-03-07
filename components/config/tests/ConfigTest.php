<?php
/**
 * This file is part of the overtrue/wechat.
 *
 * (c) zeni18 <hi.zero.im@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace zeni18\config\Tests;

use PHPUnit\Framework\TestCase;
use zeni18\config\Config;

/**
 * @internal
 * @coversNothing
 */
class CoreTest extends TestCase
{
    public $config = [
        'application' => [
            'name' => 'light php',
            'author' => [
                'name' => 'zeni18',
                'age' => 18,
            ],            ],
        'enableLog' => true,
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp()
    {
        parent::setUp();

        Config::setItems($this->config);
    }

    public function testGetEnv()
    {
        Config::env(__DIR__."/.env");


        $this->assertEquals("debug", Config::getEnv("env"));
    }

    public function testSet()
    {
        Config::set('test.name', 'light');

        $this->assertEquals('light', Config::get('test.name'));
    }

    public function testHas()
    {
        $this->assertEquals(false, Config::has('foo'));
        $this->assertEquals(true, Config::has('application'));
    }

    public function testLoadFiles()
    {
        Config::loadFiles(__DIR__.'/config');

        $this->assertEquals('1.01', Config::get('app.version'));
    }

    public function testGet()
    {
        $this->assertEquals('zeni18', Config::get('application.author.name'));
    }

    public function testSetItems()
    {
        $this->assertEquals($this->config, Config::getItems());
    }
}
