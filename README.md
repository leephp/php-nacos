# 阿里巴巴nacos配置中心-PHP客户端

[Nacos配置中心](https://github.com/alibaba/nacos)的PHP客户端，更多关于Nacos配置中心的介绍，可以查看[Nacos配置中心Wiki](https://github.com/alibaba/nacos/wiki)。

### 特性

1. 容错兜底
2. 容易上手
3. 技术支持，有问题可加作者微信: 78236656
4. 原版地址 https://github.com/neatlife/php-nacos 为了使用方便, 复制了一份, 修改了部分缺失代码, 版权依然归原作者

### 开发计划

- [x] 增强容错机制
- [x] [实现服务发现](NAMING.md)
- [x] [Laravel框架集成](https://juejin.im/post/5ccf645b6fb9a032435dba16)
- [x] Dummy模式(本地开发不走配置中心)
- [ ] Yii框架集成
- [ ] ThinkPHP框架集成
- [ ] Symfony框架集成

## Laravel框架集成



config/nacos.php 

```php
<?php
return [
    // nacos配置中心
    'LARAVEL_ENV' => 'dev',
    'LARAVEL_NACOS_SERVER_ADDR' => 'http://127.0.0.1:8848/',
    'LARAVEL_NACOS_SERVER_NAME' => 'demo-laravel-nacos',
    'LARAVEL_NACOS_IPADDRESS' => '10.10.10.20',
    'LARAVEL_NACOS_PORT' => 8080,
    'LARAVEL_NACOS_DATAID' => 'demo-laravel-nacos.env',
    'LARAVEL_NACOS_GROUPID' => 'DEFAULT_GROUP',
    'LARAVEL_NACOS_NAMESPACEID' => 'public',
];
```
bootstrap/app.php 

```php
$nacosConfig = require_once(dirname(__DIR__) . '/config/nacos.php'); 
\phpNacos\NacosConfig::setSnapshotPath(dirname(__DIR__) . "/nacos/config"); 
(new \Dotenv\Loader([], new \Dotenv\Environment\DotenvFactory(), true))->loadDirect( 
    \phpNacos\failover\LocalConfigInfoProcessor::getSnapshot( 
        $nacosConfig['LARAVEL_ENV'] ?? 'local', 
        $nacosConfig['LARAVEL_NACOS_DATAID'] ?? 'default.env', 
        $nacosConfig['LARAVEL_NACOS_GROUPID'] ?? 'DEFAULT_GROUP', 
        $nacosConfig['LARAVEL_NACOS_NAMESPACEID'] ?? 'public' 
    ) 
); 
```
app/Console/Command/Nacos.php 

```php
(new \Dotenv\Loader([], new \Dotenv\Environment\DotenvFactory(), true))->loadDirect( 
\phpNacos\Nacos::init( 
config("nacos.LARAVEL_NACOS_SERVER_ADDR"), 
config("nacos.LARAVEL_ENV"), 
config("nacos.LARAVEL_NACOS_DATAID"), 
config("nacos.LARAVEL_NACOS_GROUPID"), 
config("nacos.LARAVEL_NACOS_NAMESPACEID") ? : "" 
)->runOnce() 
); 
echo "Load Config Success!!!\n"; 
```


## composer安装

``` bash
composer require leephp/php-nacos
```

## 使用crontab拉取配置文件

定时1分钟拉取一次

```bash
*/1 * * * * php path/to/cron.php
```

```php
# cron.php
Nacos::init(
    "http://127.0.0.1:8848/",
    "dev",
    "LARAVEL",
    "DEFAULT_GROUP",
    ""
)->runOnce();
```

拉取到的配置文件路径：当前工作目录/nacos/config/dev_nacos/snapshot/LARAVEL

配置文件保存的工作目录可以通过下面命令修改

```php
NacosConfig::setSnapshotPath("指定存放配置文件的目录路径");
```

## 长轮询拉取配置文件

```php
Nacos::init(
    "http://127.0.0.1:8848/",
    "dev",
    "LARAVEL",
    "DEFAULT_GROUP",
    ""
)->listener();
```

## 事件监听器

```php
GetConfigRequestErrorListener::add(function($config) {
    if (!$config->getConfig()) {
        echo "获取配置异常, 配置为空，下面进行自定义逻辑处理" . PHP_EOL;
        // 设置是否修改配置文件内容，如果修改成true，这里设置的配置文件内容将是最终获取到的配置文件
        $config->setChanged(true);
        $config->setConfig("hello");
    }
});
```

## 配置兜底方案

将兜底的配置文件放入下面的路径里

如果有给$tenant设置值，文件路径这样计算

工作目录/nacos/config/{$env}_nacos/config-data-{$tenant}/{$dataId}

否则

工作目录/nacos/config/{$env}_nacos/config-data/{$dataId}

nacos会在无法从配置中心查询配置文件时将读取上面的配置文件

## Dummy模式(本地开发不走配置中心)

配置环境变量NACOS_ENV=local再启动项目

```shell
export NACOS_ENV=local
```

## 感谢nacos团队赠送的纪念杯

![](docs/img/nacos-mug-1.jpg)
![](docs/img/nacos-mug-2.jpg)
# php-nacos
