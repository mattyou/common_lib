<?php

use GatewayClient\Gateway;

class demo1 {
    //解析函数的参数是pluginManager的引用
    function __construct(&$pluginManager) {
        //第一个参数是钩子的名称
        //第二个参数是pluginManager的引用
        //第三个是插件所执行的方法
        $pluginManager->register(__CLASS__, $this, 'say_hello');
    }

    function say_hello($data) {
        $msg =  "获得来自 ".$data["client_id"]." 的数据：".var_export($data,true).PHP_EOL;
        Gateway::sendToClient($data["client_id"], $msg);
    }
}