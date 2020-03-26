<?php

namespace phpNacos\request\config;


use ReflectionException;
use phpNacos\Naming;
use phpNacos\model\Beat;
use phpNacos\NacosConfig;
use PHPUnit\Framework\TestCase;
use phpNacos\model\Instance;
use phpNacos\model\InstanceList;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

/**
 * Class NamingTest
 * @author JasonLee
 * @package phpNacos\request\config
 */
class NamingTest extends TestCase
{
    /**
     * @var Naming
     */
    private $discovery;

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testRegister()
    {
        $this->assertTrue($this->discovery->register());
    }

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDelete()
    {
        $this->assertTrue($this->discovery->delete());
    }

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testUpdate()
    {
        while (true) {
            $this->assertTrue($this->discovery->update(0.8));
            echo "tiemstamp " . time();
            sleep(5);
        }
    }

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testListInstances()
    {
        $instanceList = $this->discovery->listInstances();
        $this->assertInstanceOf(InstanceList::class, $instanceList);
    }

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testGet()
    {
        $this->assertInstanceOf(Instance::class, $this->discovery->get());
    }

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testBeat()
    {
        while (true) {
            $beat = $this->discovery->beat($this->discovery->get());
            $this->assertInstanceOf(Beat::class, $beat);
            echo "tiemstamp " . time();
            sleep(5);
        }
    }

    /**
     * This method is called before each test.
     */
    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        NacosConfig::setHost("http://127.0.0.1:8848/");
        NacosConfig::setIsDebug(true);
        // 长轮询10秒一次
        NacosConfig::setLongPullingTimeout(10000);
        $this->discovery = Naming::init(
            "nacos.test.1",
//            "2404:6800:8005::2e",
            "::1",
            "8848",
            "",
            "",
            false
        );
    }
}
