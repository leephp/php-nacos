<?php

namespace tests\util;


use tests\TestCase;
use phpNacos\util\EncodeUtil;

/**
 * Class EncodeTest
 * @author JasonLee
 * @package tests\util
 */
class EncodeTest extends TestCase
{
    public function testOneEncode()
    {
        $this->assertNotEmpty(EncodeUtil::oneEncode());
    }

    public function testTwoEncode()
    {
        $this->assertNotEmpty(EncodeUtil::twoEncode());
    }
}
