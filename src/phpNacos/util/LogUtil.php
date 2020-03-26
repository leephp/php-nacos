<?php


namespace phpNacos\util;

use Exception;
use Monolog\Logger;
use phpNacos\NacosConfig;
use Monolog\Handler\StreamHandler;

/**
 * Class LogUtil
 * @author JasonLee
 * @package phpNacos\util
 */
class LogUtil
{
    /**
     * @param $message
     * @param $parameters
     */
    public static function info($message, $parameters = [])
    {
        self::getLog()->info($message, $parameters);
    }

    public static function getLog()
    {
        static $log;
        if ($log == null) {
            // create a log channel
            try {
                $log = new Logger(NacosConfig::getName());
                $log->pushHandler(new StreamHandler(NacosConfig::getLogPath(), NacosConfig::getLogLevel()));
            } catch (Exception $e) {
                echo "初始化日志系统失败";
                exit(255);
            }
        }
        return $log;
    }

    /**
     * @param $message
     * @param $parameters
     */
    public static function error($message, $parameters = [])
    {
        self::getLog()->error($message, $parameters);
    }
}