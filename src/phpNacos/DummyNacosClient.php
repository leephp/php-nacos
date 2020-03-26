<?php


namespace phpNacos;


use phpNacos\failover\LocalConfigInfoProcessor;

/**
 * Class DummyNacosClient
 * @author JasonLee
 * @package phpNacos
 */
class DummyNacosClient implements NacosClientInterface
{
    public static function get($env, $dataId, $group, $tenant)
    {
        $config = "";
        LocalConfigInfoProcessor::saveSnapshot($env, $dataId, $group, $tenant, $config);
        return $config;
    }

    public static function listener($env, $dataId, $group, $config, $tenant = "")
    {
        do {
            // 短暂休息会儿
            usleep(500);
        } while (true);
    }

    public static function publish($dataId, $group, $content, $tenant = "")
    {
        return true;
    }

    public static function delete($dataId, $group, $tenant)
    {
        return true;
    }
}