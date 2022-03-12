<?php

use GatewayClient\Gateway;

class onclose {
    //解析函数的参数是pluginManager的引用
    function __construct(&$pluginManager) {
        //第一个参数是钩子的名称
        //第二个参数是pluginManager的引用
        //第三个是插件所执行的方法
        $pluginManager->register(__CLASS__, $this, 'say_hello');
    }

    function say_hello($client_id) {
        $msg =  "断开服务器，client_id:".$client_id;
        Gateway::sendToClient($client_id, $msg);
    }
}