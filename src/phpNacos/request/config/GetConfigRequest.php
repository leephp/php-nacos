<?php

namespace phpNacos\request\config;

/**
 * Class GetConfigRequest
 * @author JasonLee
 * @package phpNacos\request\config
 */
class GetConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "GET";

}