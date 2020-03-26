<?php

namespace tests\request\naming;

use tests\TestCase;
use ReflectionException;
use phpNacos\request\naming\BeatInstanceNaming;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

class BeatInstanceNamingTest extends TestCase
{

    private $beat = '{"metadata":{},"instanceId":"11.11.11.11#8848#DEFAULT#nacos.test.1","port":8848,"service":"nacos.test.1","healthy":true,"ip":"11.11.11.11","clusterName":"DEFAULT","weight":1.0}';

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $beatInstanceDiscovery = new BeatInstanceNaming();
        $beatInstanceDiscovery->setServiceName("nacos.test.1");
        $beatInstanceDiscovery->setBeat($this->beat);

        $response = $beatInstanceDiscovery->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);
        $this->assertTrue($content == '{"clientBeatInterval":5000}');
    }
}
