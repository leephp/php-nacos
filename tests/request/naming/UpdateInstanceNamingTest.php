<?php

namespace tests\request\naming;

use tests\TestCase;
use ReflectionException;
use phpNacos\request\naming\UpdateInstanceNaming;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

class UpdateInstanceNamingTest extends TestCase
{

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $updateInstanceDiscovery = new UpdateInstanceNaming();
        $updateInstanceDiscovery->setIp("11.11.11.12");
        $updateInstanceDiscovery->setPort("8848");
        $updateInstanceDiscovery->setNamespaceId("");
        $updateInstanceDiscovery->setWeight(0.5);
        $updateInstanceDiscovery->setMetadata('{"sn": 123456}');
        $updateInstanceDiscovery->setClusterName("");
        $updateInstanceDiscovery->setServiceName("nacos.test.1");

        $response = $updateInstanceDiscovery->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);
        $this->assertTrue($content == "ok");
    }
}
