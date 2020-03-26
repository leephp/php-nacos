<?php

namespace tests\util;


use Exception;
use tests\TestCase;
use phpNacos\util\LogUtil;

/**
 * Class LogUtilTest
 * @author JasonLee
 * @package tests\util
 */
class LogUtilTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testInfo()
    {
        $this->assertEmpty(LogUtil::info("info message"));
    }
}
