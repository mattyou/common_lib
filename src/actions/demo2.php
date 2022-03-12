<?php

use GatewayClient\Gateway;

class demo2 {
    //解析函数的参数是pluginManager的引用
    function __construct(&$pluginManager) {
        //第一个参数是钩子的名称
        //第二个参数是pluginManager的引用
        //第三个是插件所执行的方法
        $pluginManager->register(__CLASS__, $this, 'say_hello');
    }

    function say_hello($data) {
        echo 'Demo2...' . $data;
       // Gateway::sendToClient($data, "我来自demo,回复给" . $data);
    }
}