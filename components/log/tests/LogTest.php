<?php


/**
 *
 * This file is part of the zeni18.
 *
 * (c) zeni18 <hi.zero.im@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 */

namespace zeni18\tests;

use PHPUnit\Framework\TestCase;
use zeni18\log\Log;

class LogTest extends TestCase
{
    public $log  = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);


        $this->log = Log::single();
    }

    public function testUseFiles()
    {

        Log::single()->useFiles("./log");
        $msg = Log::info("log info");

        $this->assertFileExists("../log");

    }


}
