<?php

namespace tests\request\naming;

use tests\TestCase;
use ReflectionException;
use phpNacos\request\naming\DeleteInstanceNaming;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

class DeleteInstanceNamingTest extends TestCase
{

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $deleteInstanceDiscovery = new DeleteInstanceNaming();
        $deleteInstanceDiscovery->setIp("11.11.11.12");
        $deleteInstanceDiscovery->setPort("8848");
        $deleteInstanceDiscovery->setNamespaceId("");
        $deleteInstanceDiscovery->setClusterName("");
        $deleteInstanceDiscovery->setServiceName("nacos.test.1");

        $response = $deleteInstanceDiscovery->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);
        $this->assertTrue($content == "ok");
    }
}
