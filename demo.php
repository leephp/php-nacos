<?php
require "vendor/autoload.php";

\phpNacos\NacosConfig::setHost("http://10.50.161.137:8500/");
\phpNacos\NacosConfig::setIsDebug(true);


$naming = \phpNacos\Naming::init(
    "wenjuan-web-docker",
    "172.17.0.6",
    8195,
    '39a5a406-b482-49f6-ab2f-9cb4fad0f5d2',
    '',
    true
);

var_dump($naming->register());
while(true){
    var_dump($naming->beat());
    sleep(5);
}
//var_dump($naming->update());

