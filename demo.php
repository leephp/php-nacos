<?php
require "vendor/autoload.php";

\phpNacos\NacosConfig::setHost("http://127.0.0.1:8848/");
\phpNacos\NacosConfig::setIsDebug(true);


$naming = \phpNacos\Naming::init(
    "wenjuan-web-docker",
    "127.0.0.1",
    8080,
    '39a5a406-b482-49f6-ab2f-9cb4fad0f5d2'
);

//var_dump($naming->register());
//var_dump($naming->beat());
//var_dump($naming->update());

