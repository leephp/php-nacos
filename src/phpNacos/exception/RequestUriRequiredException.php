<?php


namespace phpNacos\exception;


use Exception;

/**
 * Class RequestUriRequiredException
 * @author JasonLee
 * @package alibaba\nacos\exception
 */
class RequestUriRequiredException extends Exception
{
    /**
     * RequestUriRequiredException constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}