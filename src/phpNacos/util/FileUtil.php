<?php


namespace phpNacos\util;


/**
 * Class FileUtil
 * @author JasonLee
 * @package phpNacos\util
 */
class FileUtil
{
    public static function deleteAll($path)
    {
        $files = glob("${$path}/*"); // get all file names
        foreach ($files as $file) { // iterate files
            if (!is_file($file)) {
                continue;
            }
            unlink($file); // delete file
        }
    }
}