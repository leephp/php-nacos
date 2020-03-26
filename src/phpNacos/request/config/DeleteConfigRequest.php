<?php

namespace phpNacos\request\config;

/**
 * Class DeleteConfigRequest
 * @author JasonLee
 * @package phpNacos\request\config
 */
class DeleteConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "DELETE";
}