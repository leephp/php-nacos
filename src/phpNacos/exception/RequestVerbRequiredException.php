<?php


namespace phpNacos\exception;


use Exception;

/**
 * Class RequestVerbRequiredException
 * @author JasonLee
 * @package phpNacos\exception
 */
class RequestVerbRequiredException extends Exception
{
    /**
     * RequestVerbRequiredException constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}