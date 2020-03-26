<?php

namespace phpNacos\request\config;


use tests\TestCase;
use ReflectionException;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

/**
 * Class ListenerConfigRequestTest
 * @author JasonLee
 * @package phpNacos\request\config
 */
class ListenerConfigRequestTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $listenerConfigRequest = new ListenerConfigRequest();
        $listenerConfigRequest->setDataId("LARAVEL");
        $listenerConfigRequest->setGroup("DEFAULT_GROUP");
        $listenerConfigRequest->setContentMD5("ddf41f9b16c588e0f6a185f4c82bf61d");

        $response = $listenerConfigRequest->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);
    }
}
