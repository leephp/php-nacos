<?php

namespace phpNacos\request\config;


use tests\TestCase;
use ReflectionException;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\exception\RequestVerbRequiredException;

/**
 * Class ListenerConfigRequestTest
 *
 * @author JasonLee
 */
class PublishConfigRequestTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public function testDoRequest()
    {
        $publishConfigRequest = new PublishConfigRequest();
        $publishConfigRequest->setDataId("LARAVEL");
        $publishConfigRequest->setGroup("DEFAULT_GROUP");
        $publishConfigRequest->setContent(file_get_contents("env-example"));

        $response = $publishConfigRequest->doRequest();
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getBody());
        $content = $response->getBody()->getContents();
        echo "content: " . $content;
        $this->assertNotEmpty($content);
    }
}
