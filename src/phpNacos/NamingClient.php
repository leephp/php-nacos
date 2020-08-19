<?php


namespace phpNacos;


use Exception;
use ReflectionException;
use phpNacos\model\Beat;
use phpNacos\util\LogUtil;
use phpNacos\model\Instance;
use phpNacos\model\InstanceList;
use phpNacos\request\naming\GetInstanceNaming;
use phpNacos\request\naming\BeatInstanceNaming;
use phpNacos\request\naming\ListInstanceNaming;
use phpNacos\request\naming\DeleteInstanceNaming;
use phpNacos\request\naming\UpdateInstanceNaming;
use phpNacos\exception\ResponseCodeErrorException;
use phpNacos\failover\LocalDiscoveryInfoProcessor;
use phpNacos\exception\RequestUriRequiredException;
use phpNacos\request\naming\RegisterInstanceNaming;
use phpNacos\exception\RequestVerbRequiredException;
use phpNacos\failover\LocalDiscoveryListInfoProcessor;

/**
 * Class NamingClient
 * @author JasonLee
 * @package phpNacos
 */
class NamingClient
{
    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $weight
     * @param string $namespaceId
     * @param bool $enable
     * @param bool $healthy
     * @param string $metadata
     * @param string $clusterName
     * @return bool
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function register($serviceName, $ip, $port, $weight = "", $namespaceId = "", $enable = 'true', $healthy = 'true', $clusterName = "", $metadata = "{}")
    {
        $registerInstanceDiscovery = new RegisterInstanceNaming();
        $registerInstanceDiscovery->setServiceName($serviceName);
        $registerInstanceDiscovery->setIp($ip);
        $registerInstanceDiscovery->setPort($port);
        $registerInstanceDiscovery->setNamespaceId($namespaceId);
        $registerInstanceDiscovery->setWeight($weight);
        $registerInstanceDiscovery->setEnable($enable);
        $registerInstanceDiscovery->setHealthy($healthy);
        $registerInstanceDiscovery->setMetadata($metadata);
        $registerInstanceDiscovery->setClusterName($clusterName);

        $response = $registerInstanceDiscovery->doRequest();
        return $response->getBody()->getContents() == "ok";
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $namespaceId
     * @param string $clusterName
     * @return bool
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function delete($serviceName, $ip, $port, $namespaceId = "", $clusterName = "")
    {
        $deleteInstanceDiscovery = new DeleteInstanceNaming();
        $deleteInstanceDiscovery->setServiceName($serviceName);
        $deleteInstanceDiscovery->setIp($ip);
        $deleteInstanceDiscovery->setPort($port);
        $deleteInstanceDiscovery->setNamespaceId($namespaceId);
        $deleteInstanceDiscovery->setClusterName($clusterName);

        $response = $deleteInstanceDiscovery->doRequest();
        return $response->getBody()->getContents() == "ok";
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param string $weight
     * @param string $namespaceId
     * @param string $clusterName
     * @param string $metadata
     * @return bool
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function update($serviceName, $ip, $port, $weight = "", $namespaceId = "", $clusterName = "", $metadata = "{}")
    {
        $updateInstanceDiscovery = new UpdateInstanceNaming();
        $updateInstanceDiscovery->setServiceName($serviceName);
        $updateInstanceDiscovery->setIp($ip);
        $updateInstanceDiscovery->setPort($port);
        $updateInstanceDiscovery->setNamespaceId($namespaceId);
        $updateInstanceDiscovery->setWeight($weight);
        $updateInstanceDiscovery->setMetadata($metadata);
        $updateInstanceDiscovery->setClusterName($clusterName);

        $response = $updateInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();
        return $content == "ok";
    }

    /**
     * @param $serviceName
     * @param bool $healthyOnly
     * @param string $namespaceId
     * @param string $clusters
     * @return model\InstanceList
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function listInstances($serviceName, $healthyOnly = false, $namespaceId = "", $clusters = "")
    {
        try {
            $listInstanceDiscovery = new ListInstanceNaming();
            $listInstanceDiscovery->setServiceName($serviceName);
            $listInstanceDiscovery->setNamespaceId($namespaceId);
            $listInstanceDiscovery->setClusters($clusters);
            $listInstanceDiscovery->setHealthyOnly($healthyOnly);

            $response = $listInstanceDiscovery->doRequest();
            $content = $response->getBody()->getContents();

            $instanceList = InstanceList::decode($content);
            LocalDiscoveryListInfoProcessor::saveSnapshot($serviceName, $namespaceId, $clusters, $instanceList);
        } catch (Exception $e) {
            LogUtil::error("查询实例列表异常，开始从本地获取配置, message: " . $e->getMessage());
            $instanceList = LocalDiscoveryListInfoProcessor::getFailover($serviceName, $namespaceId, $clusters);
            $instanceList = $instanceList ? $instanceList
                : LocalDiscoveryListInfoProcessor::getSnapshot($serviceName, $namespaceId, $clusters);
        }
        return $instanceList;
    }

    /**
     * @param $serviceName
     * @param $ip
     * @param $port
     * @param bool $healthyOnly
     * @param string $weight
     * @param string $namespaceId
     * @param string $cluster
     * @return model\Instance
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function get($serviceName, $ip, $port, $healthyOnly = false, $weight = "", $namespaceId = "", $cluster = "")
    {
        try {
            $getInstanceDiscovery = new GetInstanceNaming();
            $getInstanceDiscovery->setServiceName($serviceName);
            $getInstanceDiscovery->setIp($ip);
            $getInstanceDiscovery->setPort($port);
            $getInstanceDiscovery->setNamespaceId($namespaceId);
            $getInstanceDiscovery->setCluster($cluster);
            $getInstanceDiscovery->setHealthyOnly($healthyOnly);

            $response = $getInstanceDiscovery->doRequest();
            $content = $response->getBody()->getContents();
            $instance = Instance::decode($content);
            LocalDiscoveryInfoProcessor::saveSnapshot($serviceName, $ip, $port, $cluster, $instance);
        } catch (Exception $e) {
            LogUtil::error("查询实例详情异常，开始从本地获取配置, message: " . $e->getMessage());
            $instance = LocalDiscoveryInfoProcessor::getFailover($serviceName, $ip, $port, $cluster);
            $instance = $instance ? $instance
                : LocalDiscoveryInfoProcessor::getSnapshot($serviceName, $ip, $port, $cluster);
        }

        return $instance;
    }

    /**
     * @param $serviceName
     * @param $beat
     * @return model\Beat
     * @throws ReflectionException
     * @throws RequestUriRequiredException
     * @throws RequestVerbRequiredException
     * @throws ResponseCodeErrorException
     */
    public static function beat($serviceName, $beat)
    {
        $beatInstanceDiscovery = new BeatInstanceNaming();
        $beatInstanceDiscovery->setServiceName($serviceName);
        $beatInstanceDiscovery->setBeat($beat);
        $response = $beatInstanceDiscovery->doRequest();
        $content = $response->getBody()->getContents();
        return Beat::decode($content);
    }
}
