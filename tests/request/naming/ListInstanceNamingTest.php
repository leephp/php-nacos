<?php

namespace tests\request\naming;

use tests\TestCase;
use ReflectionException;
use phpNacos\model\InstanceList;
use phpNacos\request\naming\ListInstanceNaming;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

class RegisterInstanceDiscoveryTest extends TestCase
{

    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $listInstanceDiscovery = new ListInstanceNaming();
        $listInstanceDiscovery->setServiceName("nacos.test.1");
        $listInstanceDiscovery->setNamespaceId("");
        $listInstanceDiscovery->setClusters("");
        $listInstanceDiscovery->setHealthyOnly(false);

        $response = $listInstanceDiscovery->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);

        var_dump(InstanceList::decode($content));
        var_dump(InstanceList::decode($content)->getHosts());
    }
}
