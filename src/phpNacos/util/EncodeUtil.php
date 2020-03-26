<?php


namespace phpNacos\util;


/**
 * Class EncodeUtil
 * @author JasonLee
 * @package phpNacos\util
 */
class EncodeUtil
{
    public static function twoEncode()
    {
        return pack("C*", 2);
    }

    public static function oneEncode()
    {
        return pack("C*", 1);
    }
}