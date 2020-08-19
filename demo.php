<?php
require "vendor/autoload.php";

\phpNacos\NacosConfig::setHost("http://10.50.161.137:8500/");
\phpNacos\NacosConfig::setIsDebug(true);
$naming = \phpNacos\Naming::init(
    "wenjuan-web-docker",
    "10.50.161.177",
    8195,
    '39a5a406-b482-49f6-ab2f-9cb4fad0f5d2'
);

var_dump($naming->register());
//var_dump($naming->update());
