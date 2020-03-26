<?php


namespace phpNacos\model;


/**
 * Class Model
 * @author JasonLee
 * @package phpNacos\model
 */
abstract class Model
{
    /**
     * @param $instanceJson
     * @return Model | Instance | InstanceList | Beat | Host
     */
    public static function decode($instanceJson)
    {
        $instance = new static();
        foreach (json_decode($instanceJson) as $propertyName => $propertyValue) {
            $instance->{"set" . ucfirst($propertyName)}($propertyValue);
        }
        return $instance;
    }

    /**
     * @return false|string
     */
    public function encode()
    {
        return json_encode(get_object_vars($this));
    }
}