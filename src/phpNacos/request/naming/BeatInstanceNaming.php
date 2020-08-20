<?php

namespace phpNacos\request\naming;

class BeatInstanceNaming extends NamingRequest
{
    protected $uri = "/nacos/v1/ns/instance/beat";
    protected $verb = "PUT";

    /**
     * 服务名
     *
     * @var
     */
    private $serviceName;

    /**
     * 实例心跳内容
     *
     * @var
     */
    private $beat;

    /**
     * 实时心跳namespaceId
     * @var
     */
    private $namespaceId;

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param mixed $serviceName
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return mixed
     */
    public function getNamespaceId()
    {
        return $this->namespaceId;
    }

    /**
     * @param $namespaceId
     */
    public function setNamespaceId($namespaceId)
    {
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return mixed
     */
    public function getBeat()
    {
        return $this->beat;
    }

    /**
     * @param mixed $beat
     */
    public function setBeat($beat)
    {
        $this->beat = $beat;
    }
}
